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
        Schema::table('student_badges', function (Blueprint $table) {
            $table->boolean('is_unlocked')->default(false)->after('badge_id');
        $table->timestamp('unlocked_at')->nullable()->after('is_unlocked');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_badges', function (Blueprint $table) {
             $table->dropColumn(['is_unlocked', 'unlocked_at']);
        });
    }
};
