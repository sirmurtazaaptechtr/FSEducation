<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mou_partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('organization_type', [
                'corporate', 'school', 'college', 'university', 'ngo', 'association', 'other'
            ])->default('corporate')->index();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('website_url')->nullable();
            $table->date('signed_on')->nullable();
            $table->date('valid_from')->nullable()->index();
            $table->date('valid_until')->nullable()->index();
            $table->enum('discount_type', ['percentage', 'fixed', 'custom_text'])->default('percentage');
            $table->string('discount_value')->nullable();
            $table->string('discount_label');
            $table->text('terms')->nullable();
            $table->text('how_to_avail')->nullable();
            $table->string('referral_code')->nullable()->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();

            // Compound index for active MOU lookup
            $table->index(['is_active', 'valid_from', 'valid_until']);
        });

        Schema::create('mou_partner_brand', function (Blueprint $table) {
            $table->foreignId('mou_partner_id')->constrained('mou_partners')->cascadeOnDelete();
            $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
            $table->primary(['mou_partner_id', 'brand_id']);
        });

        Schema::create('mou_partner_course', function (Blueprint $table) {
            $table->foreignId('mou_partner_id')->constrained('mou_partners')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->primary(['mou_partner_id', 'course_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mou_partner_course');
        Schema::dropIfExists('mou_partner_brand');
        Schema::dropIfExists('mou_partners');
    }
};
