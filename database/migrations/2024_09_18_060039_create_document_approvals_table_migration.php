<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('document_approvals', function (Blueprint $table) {
            $table->bigIncrements('id'); // Changed to bigIncrements
            $table->uuid('document_id'); // Changed to unsignedInteger
            $table->text('resolution')->nullable();
            $table->string('overall_state')->nullable();
            $table->uuid('destination')->nullable(); // Changed to unsignedBigInteger
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('document_id')->references('item_id')->on('documents')->onDelete('cascade');
            $table->foreign('destination')->references('id')->on('items')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_approvals');
    }
};
