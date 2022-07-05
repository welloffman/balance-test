<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->double('amount', 8, 2);
            $table->enum('type', ['debit', 'credit']);
            $table->string('description');
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
}
