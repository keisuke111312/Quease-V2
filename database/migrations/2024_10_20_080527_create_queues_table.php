<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreignId('creator_id')->nullable()->constrained('users');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->string('fname');
            $table->string('lname');
            $table->string('contact');
            $table->string('email');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->boolean('is_denied')->default(false);  
            $table->boolean('can_escalate')->default(false);  
            $table->enum('status', ['pending', 'approved', 'serving', 'done','completed', 'not available','lapse'])->default('pending');
            $table->string('otherText')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->string('problem')->nullable();
            $table->string('resolve')->nullable();
            $table->string('remarks')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queues');
    }
}
