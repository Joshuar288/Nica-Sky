<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('plan')->default('free')->after('is_verified');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_recommended')->default(false)->index()->after('views_count');
        });

        DB::table('users')->where('is_verified', true)->update(['plan' => 'pro_3']);

        DB::table('products')
            ->whereIn('user_id', DB::table('users')->where('plan', 'pro_3')->select('id'))
            ->update(['is_recommended' => true]);
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_recommended');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('plan');
        });
    }
};
