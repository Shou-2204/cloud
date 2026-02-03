<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add index on team_ratings.session_hash for anti-spam lookups
        Schema::table('team_ratings', function (Blueprint $table) {
            $table->index('session_hash');
        });

        // 2. Convert team_invoices.amount from varchar to decimal
        // First, we need to handle existing data
        Schema::table('team_invoices', function (Blueprint $table) {
            $table->decimal('amount_new', 10, 2)->nullable()->after('amount');
        });

        // Migrate existing data (amounts might be stored as "19.99" or similar)
        DB::statement('UPDATE team_invoices SET amount_new = CAST(amount AS DECIMAL(10,2))');

        Schema::table('team_invoices', function (Blueprint $table) {
            $table->dropColumn('amount');
        });

        Schema::table('team_invoices', function (Blueprint $table) {
            $table->renameColumn('amount_new', 'amount');
        });

        // Make amount not nullable after migration
        Schema::table('team_invoices', function (Blueprint $table) {
            $table->decimal('amount', 10, 2)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert amount back to varchar
        Schema::table('team_invoices', function (Blueprint $table) {
            $table->string('amount_varchar')->after('amount');
        });

        DB::statement('UPDATE team_invoices SET amount_varchar = CAST(amount AS CHAR)');

        Schema::table('team_invoices', function (Blueprint $table) {
            $table->dropColumn('amount');
        });

        Schema::table('team_invoices', function (Blueprint $table) {
            $table->renameColumn('amount_varchar', 'amount');
        });

        // Remove index on session_hash
        Schema::table('team_ratings', function (Blueprint $table) {
            $table->dropIndex(['session_hash']);
        });
    }
};
