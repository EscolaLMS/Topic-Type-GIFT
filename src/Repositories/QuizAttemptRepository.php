<?php

namespace EscolaLms\TopicTypeGift\Repositories;

use EscolaLms\Core\Dtos\OrderDto;
use EscolaLms\Core\Repositories\BaseRepository;
use EscolaLms\TopicTypeGift\Models\GiftQuestion;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use EscolaLms\TopicTypeGift\Repositories\Contracts\QuizAttemptRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class QuizAttemptRepository extends BaseRepository implements QuizAttemptRepositoryContract
{
    public function model(): string
    {
        return QuizAttempt::class;
    }

    public function getFieldsSearchable(): array
    {
        return [
            'user_id',
            'topic_gift_quiz_id',
        ];
    }

    public function findByCriteria(array $criteria, int $perPage, ?OrderDto $orderDto = null): LengthAwarePaginator
    {
        $query = $this->queryWithAppliedCriteria($criteria);

        $query = $this->orderBy($query);
        return $query->paginate($perPage);
    }

    public function queryByUserIdAndQuizId(int $userId, int $quizId): Builder
    {
        return $this->allQuery([
            'user_id' => $userId,
            'topic_gift_quiz_id' => $quizId,
        ]);
    }

    public function findActive(int $userId, int $quizId): ?QuizAttempt
    {
        return $this->queryByUserIdAndQuizId($userId, $quizId)->active()->first();
    }

    public function orderBy(Builder $query, OrderDto $orderDto): Builder
    {
        return match ($orderDto->getOrderBy()) {
            'result_score' => $query
                ->withSum('answers', 'score')
                ->orderBy('answers_sum_score', 'desc'),
            'max_score' => $query
                ->select(['question_scores.total_score', 'topic_gift_quiz_attempts.*'])
                ->leftJoinSub(GiftQuestion::selectRaw('topic_gift_questions.topic_gift_quiz_id, SUM(score) as total_score')->groupBy('topic_gift_questions.topic_gift_quiz_id'), 'question_scores', function ($join) {
                    $join->on('question_scores.topic_gift_quiz_id', '=', 'topic_gift_quiz_attempts.topic_gift_quiz_id');
                })
                ->orderBy('total_score', 'desc'),
            default => $query->orderBy($orderDto->getOrderBy() ?? 'id', $orderDto->getOrder() ?? 'asc'),
        };

    }
}
