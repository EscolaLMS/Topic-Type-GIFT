<?php

namespace EscolaLms\TopicTypeGift\Http\Requests\Admin;

use EscolaLms\TopicTypeGift\Enum\TopicTypeGiftPermissionEnum;
use EscolaLms\TopicTypeGift\Models\QuizAttempt;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class AdminExportQuizResultsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('list', QuizAttempt::class);
    }

    public function rules(): array
    {
        return [
            'course_id' => ['required', 'integer'],
            'topic_gift_quiz_id' => ['sometimes', 'nullable', 'integer'],
        ];
    }

    public function getCourseId(): int
    {
        return (int) $this->get('course_id');
    }

    public function getQuizId(): ?int
    {
        return $this->get('topic_gift_quiz_id') ? (int) $this->get('topic_gift_quiz_id') : null;
    }

    /**
     * When the user only has the "list self" permission (tutor), scope the export
     * to courses they author - mirroring the list endpoint behaviour. Users with the
     * full "list" permission (admin) get null (no author scoping).
     */
    public function getAuthorId(): ?int
    {
        $user = $this->user();

        if ($user->can(TopicTypeGiftPermissionEnum::LIST_QUIZ_ATTEMPT)) {
            return null;
        }

        return $user->getKey();
    }
}
