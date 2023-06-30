<?php

namespace EscolaLms\TopicTypeGift\Enum;

use EscolaLms\Core\Enums\BasicEnum;

class TopicTypeGiftPermissionEnum extends BasicEnum
{
    public const CREATE_OWN_QUIZ_ATTEMPT = 'quiz-attempt_create-own';
    public const LIST_OWN_QUIZ_ATTEMPT = 'quiz-attempt_list-own';
    public const READ_OWN_QUIZ_ATTEMPT = 'quiz-attempt_read-own';

    public const LIST_QUIZ_ATTEMPT = 'quiz-attempt_list';
    public const READ_QUIZ_ATTEMPT = 'quiz-attempt_read';

    public const UPDATE_QUIZ_ATTEMPT = 'quiz-attempt_update';

    public const READ_GIFT_QUIZ = 'gift-quiz_read';
    public const CREATE_GIFT_QUIZ_QUESTION = 'gift-quiz-question_create';
    public const UPDATE_GIFT_QUIZ_QUESTION = 'gift-quiz-question_update';
    public const DELETE_GIFT_QUIZ_QUESTION = 'gift-quiz-question_delete';

    public static function studentPermissions():array
    {
        return [
            TopicTypeGiftPermissionEnum::CREATE_OWN_QUIZ_ATTEMPT,
            TopicTypeGiftPermissionEnum::LIST_OWN_QUIZ_ATTEMPT,
            TopicTypeGiftPermissionEnum::READ_OWN_QUIZ_ATTEMPT,
        ];
    }

    public static function tutorPermissions(): array
    {
        return [
            TopicTypeGiftPermissionEnum::CREATE_GIFT_QUIZ_QUESTION,
            TopicTypeGiftPermissionEnum::UPDATE_GIFT_QUIZ_QUESTION,
            TopicTypeGiftPermissionEnum::DELETE_GIFT_QUIZ_QUESTION,
        ];
    }
}
