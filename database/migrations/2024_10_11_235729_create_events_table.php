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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->enum('type',['Upcomming', 'Completed'])->default("Upcomming")->comment("A event may be upcoming or completed.");
            $table->string('event_id',20)->unique()->comment("Every event has a unique ID for easy identification.");
            $table->text("description")->nullable();
            $table->tinyInteger('status')->comment("A event is Active with status 1 and Inactive with status 2.");
            $table->timestamp('event_time');
            $table->unsignedBigInteger('created_by')->comment("ID of the user who created this event.");
            $table->unsignedBigInteger('updated_by')->nullable()->comment("ID of the user who updated this event.");
            $table->unsignedBigInteger('deleted_by')->nullable()->comment("ID of the user who deleted this event.");
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
