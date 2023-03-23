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
        Schema::create('nctk_user', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('username',100);
            $table->string('password',64);
            $table->string('email',100);
            $table->string('phone',11);
            $table->string('image')->nullable();
            $table->unsignedTinyInteger('roles');
            $table->string('address',1000)->nullable();
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
        Schema::dropIfExists('nctk_user');
    }
};