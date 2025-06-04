<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->uuid('id')->change();

            // Add new columns
            $table->timestamp('paid_at')->nullable()->after('is_paid');
            $table->string('payment_id')->nullable()->after('paid_at');
            $table->string('payment_gateway')->nullable()->after('payment_id');
        });

        // Generate UUIDs for existing records
        DB::table('payments')->get()->each(function ($payment) {
            DB::table('payments')
                ->where('id', $payment->id)
                ->update(['id' => (string) \Illuminate\Support\Str::uuid()]);
        });

        // Add unique index for UUID
        Schema::table('payments', function (Blueprint $table) {
            $table->unique('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
            $table->dropColumn(['paid_at', 'payment_id', 'payment_gateway']);
        });
    }
};
