<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('moderation_status')->default('pending')->index()->after('is_recommended');
            $table->foreignId('moderated_by')->nullable()->constrained('users')->nullOnDelete()->after('moderation_status');
            $table->text('moderation_notes')->nullable()->after('moderated_by');
            $table->timestamp('moderated_at')->nullable()->after('moderation_notes');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['moderated_by']);
            $table->dropColumn(['moderation_status', 'moderated_by', 'moderation_notes', 'moderated_at']);
        });
    }
};
