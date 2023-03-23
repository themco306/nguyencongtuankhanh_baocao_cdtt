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
        Schema::create('nctk_category', function (Blueprint $table) {
            $table->id();
            $table->string('name',1000);
            $table->string('slug',1500);
            $table->unsignedInteger('parent_id');
            $table->unsignedSmallInteger('sort_order');
            $table->string('metakey');
            $table->string('metakeydesc',1500);
            $table->unsignedInteger('created_by')->default(1);
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedTinyInteger('status')->default(2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nctk_category');
    }
};