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
        Schema::create('crawled_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_source_id')->constrained();
            $table->string('url');
            $table->string('title');
            $table->text('content');
            $table->timestamp('original_date')->nullable();
            $table->timestamps();
            
            $table->unique(['blog_source_id', 'url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crawled_posts');
    }
};
