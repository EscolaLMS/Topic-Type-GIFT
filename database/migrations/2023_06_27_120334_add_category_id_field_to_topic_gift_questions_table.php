<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdFieldToTopicGiftQuestionsTable extends Migration
{
    public function up(): void
    {
        Schema::table('topic_gift_questions', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('topic_gift_questions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
}
