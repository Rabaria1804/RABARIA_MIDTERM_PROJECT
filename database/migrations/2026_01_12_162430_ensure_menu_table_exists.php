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
        if (!Schema::hasTable('menu')) {
            Schema::create('menu', function (Blueprint $table) {
                $table->id();
                $table->string('dish')->unique();
                $table->foreignId('category_id')
                    ->nullable()
                    ->constrained('categories')
                    ->onDelete('set null');
                $table->decimal('price', 8, 2);
                $table->text('description')->nullable();
                $table->string('photo')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        } else {
            // If table exists, just add missing columns
            Schema::table('menu', function (Blueprint $table) {
                if (!Schema::hasColumn('menu', 'category_id')) {
                    $table->foreignId('category_id')
                        ->nullable()
                        ->constrained('categories')
                        ->onDelete('set null');
                }
                if (!Schema::hasColumn('menu', 'photo')) {
                    $table->string('photo')->nullable();
                }
                if (!Schema::hasColumn('menu', 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down() to preserve data
    }
};
