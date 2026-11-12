<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->foreignId('course_category_id')->constrained('course_categories')->cascadeOnDelete();
            $table->foreignId('affiliation_id')->nullable()->constrained('affiliations')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('duration')->nullable();
            $table->string('eligibility')->nullable();
            $table->string('fee_note')->nullable();
            $table->text('outcomes')->nullable();
            $table->string('image')->nullable();
            $table->enum('approval_status', ['none', 'pending', 'approved'])->default('none')->index();
            $table->string('registration_reference')->nullable();
            $table->text('approval_note')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();

            // Compound index for fast filtered public catalog queries
            $table->index(['is_active', 'brand_id', 'course_category_id']);
        });

        Schema::create('centre_course', function (Blueprint $table) {
            $table->foreignId('centre_id')->constrained('centres')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->primary(['centre_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('centre_course');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('course_categories');
    }
};
