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
        Schema::create('activity_logs', function (Blueprint $table) {
          $table->id();
          $table->string('name');
          $table->string('description');
          $table->string('assign_person');
          $table->tinyInteger('is_active')->default(1);
          $table->unsignedBigInteger('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->timestamps();
          $table->softDeletes();
          $table->string('created_by')->nullable();
          $table->string( 'updated_by' )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
