<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('hook_propose');
            $table->json('body_points');
            $table->integer('technical_readability_score');
            $table->string('suggested_hashtag');
            $table->text('tone_compliance_justification');
            $table->json('payload_brut')->nullable();
            $table->string('status')->default('draft');
            $table->foreignId('raw_content_id')->constrained('raw_contents')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
