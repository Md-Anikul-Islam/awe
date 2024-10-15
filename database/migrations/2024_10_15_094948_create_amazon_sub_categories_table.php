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
        Schema::create('amazon_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('amazon_category_id')->constrained('amazon_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('referral_fee')->nullable();
            $table->string('size_tier_type')->nullable();
            $table->string('shipping_weight')->nullable();
            $table->string('fba_fee')->nullable();
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amazon_sub_categories');
    }
};
