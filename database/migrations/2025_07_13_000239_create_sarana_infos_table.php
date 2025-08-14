<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sarana_infos', function (Blueprint $table) {
            $table->id();
            $table->string('sarana');                      // Contoh: Aula, Ruang Rapat, Proyektor
            $table->string('status');                      // Contoh: Tersedia, Sudah dibooking, Dalam perawatan
            $table->text('keterangan')->nullable();        // Penjelasan tambahan
            $table->date('mulai')->nullable();             // Tanggal mulai berlaku
            $table->date('sampai')->nullable();            // Tanggal selesai (opsional)
            $table->boolean('ditampilkan')->default(true); // Tampilkan di landing page atau tidak
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sarana_infos');
    }
};

