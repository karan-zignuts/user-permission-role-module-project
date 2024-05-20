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
        Schema::create('user_roles', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('user_id')->unsigned()->nullable();
          $table->unsignedBigInteger('role_id')->unsigned()->nullable();
          $table->timestamps();
          $table->softDeletes();
          $table->string('created_by')->nullable();
          $table->string( 'updated_by' )->nullable();

          $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
