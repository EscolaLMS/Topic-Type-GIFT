<?php

namespace EscolaLms\TopicTypeGift\Http\Resources;

use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *      schema="QuizAttemptSimpleResource",
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="user_id",
 *          description="user_id",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="topic_gift_quiz_id",
 *          description="topic_gift_quiz_id",
 *          type="number"
 *      ),
 *      @OA\Property(
 *          property="started_at",
 *          description="started_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="end_at",
 *          description="end_at",
 *          type="string",
 *          format="date-time"
 *      ),
 *      @OA\Property(
 *          property="is_ended",
 *          description="is_ended",
 *          type="boolean"
 *      ),
 *      @OA\Property(
 *          property="min_pass_score",
 *          description="min pass score",
 *          type="number"
 *      ),
 *     @OA\Property(
 *          property="user",
 *          description="user",
 *          type="object"
 *      ),
 *     @OA\Property(
 *          property="course",
 *          description="course",
 *          type="object"
 *      ),
 * )
 *
 */

/**
 * @mixin QuizAttempt
 */
class QuizAttemptSimpleResource extends JsonResource
{
    public function toArray($request): array
    {
        $maxScore = $this->giftQuiz->questions->sum('score');
        $resultScore = $this->answers->sum('score');
        $course = $this->giftQuiz?->topic?->lesson?->course;

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'topic_gift_quiz_id' => $this->topic_gift_quiz_id,
            'started_at' => $this->started_at,
            'end_at' => $this->end_at,
            'max_score' => $maxScore,
            'min_pass_score' => $this->giftQuiz->min_pass_score,
            'result_score' => $this->isEnded() ? $resultScore : null,
            'is_ended' => $this->isEnded(),
            'user' => UserSimpleResource::make($this->user),
            'course' => $course ? CourseSimpleResource::make($course) : null,
        ];
    }
}
