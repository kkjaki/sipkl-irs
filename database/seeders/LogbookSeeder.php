<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
{
    $student = \App\Models\Student::first();
    // Karena mentor_id merujuk ke tabel users, kita ambil user pertama (biasanya admin/owner)
    $user = \App\Models\User::first(); 

    if ($student && $user) {
        \App\Models\Logbook::create([
            'student_id' => $student->id,
            'mentor_id' => $user->id, // Sesuaikan dengan user yang bertindak sebagai mentor
            'notes' => 'Hari ini saya belajar mengintegrasikan branch GitHub dan memperbaiki fitur database.',
            'documentation_file' => 'logbooks/dummy-work.jpg',
            'status' => 'pending',
        ]);

        $this->command->info('✅ Berhasil membuat data logbook dummy dengan struktur baru!');
    } else {
        $this->command->error('❌ Pastikan tabel students dan users sudah ada isinya!');
    }
}
}
