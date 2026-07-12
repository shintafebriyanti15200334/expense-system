<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ROLES
        |--------------------------------------------------------------------------
        */
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            $table->foreignId('role_id')
                ->constrained('roles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name');

            $table->string('email')->unique();

            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');

            $table->rememberToken();

            $table->timestamps();
        });

        /*
        |--------------------------------------------------------------------------
        | PASSWORD RESET
        |--------------------------------------------------------------------------
        */
        Schema::create('password_reset_tokens', function (Blueprint $table) {

            $table->string('email')->primary();

            $table->string('token');

            $table->timestamp('created_at')->nullable();

        });

        /*
        |--------------------------------------------------------------------------
        | SESSIONS
        |--------------------------------------------------------------------------
        */
        Schema::create('sessions', function (Blueprint $table) {

            $table->string('id')->primary();

            $table->foreignId('user_id')->nullable()->index();

            $table->string('ip_address',45)->nullable();

            $table->text('user_agent')->nullable();

            $table->longText('payload');

            $table->integer('last_activity')->index();

        });

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */

        Schema::create('categories', function (Blueprint $table) {

            $table->id();

            $table->string('name');

            $table->text('description')->nullable();

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | BUDGETS
        |--------------------------------------------------------------------------
        */

        Schema::create('budgets', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->decimal('budget_amount',18,2);

            $table->decimal('used_amount',18,2)->default(0);

            $table->year('year');

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | SUBMISSIONS
        |--------------------------------------------------------------------------
        */

        Schema::create('submissions', function (Blueprint $table) {

            $table->id();

            $table->string('submission_number')->unique();

            $table->date('submission_date');

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->decimal('amount',18,2);

            $table->text('description');

            $table->string('attachment')->nullable();

            $table->enum('status',[
                'Draft',
                'Submitted',
                'Waiting SPV Approval',
                'Waiting Manager Approval',
                'Waiting Director Approval',
                'Waiting Finance',
                'Paid',
                'Rejected'
            ])->default('Draft');

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | APPROVALS
        |--------------------------------------------------------------------------
        */

        Schema::create('approvals', function (Blueprint $table) {

            $table->id();

            $table->foreignId('submission_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('approver_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->enum('level',[
                'SPV',
                'Manager',
                'Director'
            ]);

            $table->enum('status',[
                'Pending',
                'Approved',
                'Rejected'
            ])->default('Pending');

            $table->text('notes')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->timestamps();

        });

        /*
        |--------------------------------------------------------------------------
        | PAYMENTS
        |--------------------------------------------------------------------------
        */

        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('submission_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('finance_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date('payment_date')->nullable();

            $table->decimal('paid_amount',18,2);

            $table->enum('status',[
                'Pending',
                'Paid',
                'Rejected'
            ])->default('Pending');

            $table->text('notes')->nullable();

            $table->timestamps();

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('payments');

        Schema::dropIfExists('approvals');

        Schema::dropIfExists('submissions');

        Schema::dropIfExists('budgets');

        Schema::dropIfExists('categories');

        Schema::dropIfExists('sessions');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('users');

        Schema::dropIfExists('roles');
    }
};