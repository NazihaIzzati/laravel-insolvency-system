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
        // For SQLite, we need to recreate the table to modify the CHECK constraint
        if (DB::getDriverName() === 'sqlite') {
            // First, create a new table with the updated constraint
            DB::statement('
                CREATE TABLE users_new (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    email_verified_at DATETIME,
                    password VARCHAR(255) NOT NULL,
                    role VARCHAR(255) NOT NULL DEFAULT "staff" CHECK (role IN ("superuser", "admin", "id_management", "staff")),
                    is_active BOOLEAN NOT NULL DEFAULT 1,
                    last_login_at DATETIME,
                    remember_token VARCHAR(100),
                    created_at DATETIME,
                    updated_at DATETIME,
                    deleted_at DATETIME
                )
            ');

            // Copy data from old table to new table
            DB::statement('
                INSERT INTO users_new (id, name, email, email_verified_at, password, role, is_active, last_login_at, remember_token, created_at, updated_at, deleted_at)
                SELECT id, name, email, email_verified_at, password, 
                       CASE 
                           WHEN role = "user" THEN "staff"
                           ELSE role
                       END as role,
                       COALESCE(is_active, 1) as is_active,
                       last_login_at, remember_token, created_at, updated_at, deleted_at
                FROM users
            ');

            // Drop old table
            DB::statement('DROP TABLE users');

            // Rename new table
            DB::statement('ALTER TABLE users_new RENAME TO users');

            // Recreate indexes
            DB::statement('CREATE UNIQUE INDEX users_email_unique ON users (email)');
            DB::statement('CREATE INDEX users_deleted_at_index ON users (deleted_at)');
        } else {
            // For other databases, use standard ALTER TABLE
            Schema::table('users', function (Blueprint $table) {
                $table->dropCheck(['role']);
                $table->check('role IN ("superuser", "admin", "id_management", "staff")');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // Revert to original constraint
            DB::statement('
                CREATE TABLE users_old (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    email_verified_at DATETIME,
                    password VARCHAR(255) NOT NULL,
                    role VARCHAR(255) NOT NULL DEFAULT "user" CHECK (role IN ("admin", "user")),
                    is_active BOOLEAN NOT NULL DEFAULT 1,
                    last_login_at DATETIME,
                    remember_token VARCHAR(100),
                    created_at DATETIME,
                    updated_at DATETIME,
                    deleted_at DATETIME
                )
            ');

            DB::statement('
                INSERT INTO users_old (id, name, email, email_verified_at, password, role, is_active, last_login_at, remember_token, created_at, updated_at, deleted_at)
                SELECT id, name, email, email_verified_at, password, 
                       CASE 
                           WHEN role = "staff" THEN "user"
                           WHEN role = "superuser" THEN "admin"
                           WHEN role = "id_management" THEN "admin"
                           ELSE role
                       END as role,
                       is_active, last_login_at, remember_token, created_at, updated_at, deleted_at
                FROM users
            ');

            DB::statement('DROP TABLE users');
            DB::statement('ALTER TABLE users_old RENAME TO users');
            DB::statement('CREATE UNIQUE INDEX users_email_unique ON users (email)');
            DB::statement('CREATE INDEX users_deleted_at_index ON users (deleted_at)');
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->dropCheck(['role']);
                $table->check('role IN ("admin", "user")');
            });
        }
    }
};