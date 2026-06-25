<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('expenses')) {
            Schema::create('expenses', function (Blueprint $table) {
                $table->id();
                $table->string('category');
                $table->text('description')->nullable();
                $table->decimal('amount', 10, 2);
                $table->date('expense_date');
                $table->string('payment_method')->default('cash');
                $table->string('receipt')->nullable();
                $table->text('notes')->nullable();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        } // <-- this closing brace was missing
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};