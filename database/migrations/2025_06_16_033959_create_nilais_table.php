    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::create('nilais', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ujian_id')->constrained('ujians')->onDelete('cascade');
                $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
                $table->decimal('nilai', 5, 2); // Nilai bisa desimal, misal 85.50
                $table->timestamps();

                // Mencegah satu siswa memiliki dua nilai untuk ujian yang sama
                $table->unique(['ujian_id', 'siswa_id']);
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('nilais');
        }
    };
    