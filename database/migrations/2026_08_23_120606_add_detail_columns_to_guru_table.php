<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('nama');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('nip');
            $table->string('ttl')->nullable()->after('jenis_kelamin');
            $table->string('jabatan')->nullable()->after('mata_pelajaran');
            $table->text('alamat')->nullable()->after('no_telepon');
        });
    }

    public function down(): void
    {
        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn(['nip', 'jenis_kelamin', 'ttl', 'jabatan', 'alamat']);
        });
    }
};