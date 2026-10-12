<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('document_type')->default('DNI')->after('name');
            $table->string('last_name_paternal')->nullable()->after('document_type');
            $table->string('last_name_maternal')->nullable()->after('last_name_paternal');
            $table->date('birth_date')->nullable()->after('email');
            $table->string('gender')->nullable()->after('birth_date');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['document_type', 'last_name_paternal', 'last_name_maternal', 'birth_date', 'gender']);
        });
    }
};