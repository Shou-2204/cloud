<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            Schema::dropIfExists('crm_contacts');
            Schema::create('crm_contacts', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->foreignId('team_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->boolean('marketing_consent')->default(false);
                $table->timestamp('last_visited_at')->nullable();
                $table->integer('visit_count')->default(0);
                $table->string('source')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
            return;
        }

        // 1. Add uuid column
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        // 2. Populate UUIDv7 for existing rows
        foreach (DB::table('crm_contacts')->select('id')->cursor() as $row) {
            DB::table('crm_contacts')
                ->where('id', $row->id)
                ->update(['uuid' => Str::uuid7()->toString()]);
        }

        // 3. MySQL: remove auto_increment before dropping primary key
        if (DB::getDriverName() !== 'sqlite') DB::statement('ALTER TABLE crm_contacts MODIFY id BIGINT UNSIGNED NOT NULL');
        if (DB::getDriverName() !== 'sqlite') DB::statement('ALTER TABLE crm_contacts DROP PRIMARY KEY');

        // 4. Drop old id, rename uuid to id, set as primary
        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->dropColumn('id');
        });

        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->renameColumn('uuid', 'id');
        });

        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->uuid('id')->primary()->change();
        });
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn('id');
        });

        Schema::table('crm_contacts', function (Blueprint $table) {
            $table->id();
        });
    }
};
