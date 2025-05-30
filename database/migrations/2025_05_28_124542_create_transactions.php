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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedInteger('coa_code');
            $table->string('description');
            $table->decimal('debit', 15, 0)->default(0);
            $table->decimal('credit', 15, 0)->default(0);
            $table->timestamps();

            $table->foreign('coa_code')->references('code')->on('chart_of_accounts')->onDelete('cascade');
            $table->index(['date', 'coa_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
