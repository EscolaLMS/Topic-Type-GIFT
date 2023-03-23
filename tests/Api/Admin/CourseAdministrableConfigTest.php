<?php

namespace EscolaLms\TopicTypeGift\Tests\Api\Admin;

use EscolaLms\Core\Tests\CreatesUsers;
use EscolaLms\TopicTypeGift\Providers\SettingsServiceProvider;
use EscolaLms\TopicTypeGift\Tests\TestCase;

class CourseAdministrableConfigTest extends TestCase
{
    use CreatesUsers;

    public function testAdministrableConfigApi(): void
    {
        $configKey = SettingsServiceProvider::KEY;

        $this->actingAs($this->makeAdmin(), 'api')->postJson('api/admin/config', [
            'config' => [
                [
                    'key' => "{$configKey}.max_quiz_time",
                    'value' => 123,
                ],
            ],
        ])->assertOk();

        $this->actingAs($this->makeAdmin(), 'api')->getJson('api/admin/config')
            ->assertOk()
            ->assertJsonFragment([
                $configKey => [
                    'max_quiz_time' => [
                        'full_key' => "$configKey.max_quiz_time",
                        'key' => 'max_quiz_time',
                        'rules' => [
                            'required',
                            'integer',
                            'min:1',
                        ],
                        'public' => false,
                        'value' => 123,
                        'readonly' => false,
                    ],
                ],
            ]);

        $this->getJson('api/config')
            ->assertJsonMissing(['max_quiz_time']);
    }
}
