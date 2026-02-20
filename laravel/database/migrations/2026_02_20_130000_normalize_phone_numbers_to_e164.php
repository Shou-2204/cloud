<?php

use App\Helpers\PhoneHelper;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Normalize existing phone numbers to E.164 format
        $this->normalizeTable('users', 'phone');
        $this->normalizeTable('team_profiles', 'phone');
        $this->normalizeTable('leads', 'phone');
        $this->normalizeTable('crm_contacts', 'phone');

        // Add unique indexes.
        // MySQL natively allows multiple NULLs in a UNIQUE index, so no partial index syntax needed.
        // SQLite also supports this.
        Schema::table('users', function (Blueprint $table) {
            $table->unique('phone', 'users_phone_unique');
        });
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->unique(['team_id', 'phone'], 'crm_contacts_team_phone_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_phone_unique');
        });
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->dropIndex('crm_contacts_team_phone_unique');
        });
    }

    /**
     * Normalize phone numbers in a given table.
     */
    private function normalizeTable(string $table, string $column): void
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, $column)) {
            return;
        }

        $rows = DB::table($table)
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->select(['id', $column])
            ->get();

        foreach ($rows as $row) {
            $original = $row->{$column};
            $normalized = PhoneHelper::toE164($original);

            if ($normalized !== $original && $normalized !== null) {
                DB::table($table)
                    ->where('id', $row->id)
                    ->update([$column => $normalized]);
            } elseif ($normalized === $original && !str_starts_with($original, '+')) {
                // Phone couldn't be parsed to E.164 - log it
                Log::warning("Phone normalization: could not normalize '{$original}' in {$table}.id={$row->id}");
            }
        }
    }
};
