<?php

namespace Database\Seeders;

use App\Models\AttendanceSession;
use App\Models\Criterion;
use App\Models\Grade;
use App\Models\Industry;
use App\Models\InternshipProgram;
use App\Models\School;
use App\Models\SchoolSupervisor;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FullDataSeeder extends Seeder
{
    /**
     * Seed industries, internship programs, schools, supervisors,
     * students, criteria, and grades in one go.
     */
    public function run(): void
    {
        // ──────────────────────────────────────────────
        // 1. Owner users + Industries
        // ──────────────────────────────────────────────
        $industriesData = [
            [
                'owner' => ['name' => 'Budi Santoso', 'email' => 'budi@industry.com'],
                'industry' => ['name' => 'PT Teknologi Nusantara', 'address' => 'Jl. Sudirman No. 10, Jakarta', 'phone' => '021123456', 'latitude' => '-6.208763', 'longitude' => '106.845599'],
            ],
        ];

        $industries = [];
        foreach ($industriesData as $data) {
            $owner = User::firstOrCreate(
            ['email' => $data['owner']['email']],
            [
                'name' => $data['owner']['name'],
                'password' => Hash::make('password'),
                'role' => 'owner',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
            );

            $industry = Industry::firstOrCreate(
            ['owner_id' => $owner->id],
                $data['industry']
            );

            $industries[] = $industry;
        }

        $this->command->info('✅ Created ' . count($industries) . ' industries with owners.');

        // ──────────────────────────────────────────────
        // 2. Schools + Supervisors (per industry)
        // ──────────────────────────────────────────────
        $schoolsData = [
            ['name' => 'SMK Negeri 1 Jakarta', 'address' => 'Jl. Gatot Subroto No. 20, Jakarta', 'phone' => '021111222'],
        ];

        $supervisorsData = [
            ['name' => 'Pak Agus Wibowo', 'phone' => '081200001111'],
        ];

        $allSchools = [];
        $allSupervisors = [];

        foreach ($industries as $industry) {
            foreach ($schoolsData as $i => $schoolData) {
                $school = School::firstOrCreate(
                ['industry_id' => $industry->id, 'name' => $schoolData['name']],
                    $schoolData
                );
                $allSchools[] = $school;

                // One supervisor per school
                $supData = $supervisorsData[$i % count($supervisorsData)];
                $supervisor = SchoolSupervisor::firstOrCreate(
                ['school_id' => $school->id, 'name' => $supData['name']],
                    $supData
                );
                $allSupervisors[] = $supervisor;
            }
        }

        $this->command->info('✅ Created ' . count($allSchools) . ' schools with supervisors.');

        // ──────────────────────────────────────────────
        // 3. Internship Programs (per industry)
        // ──────────────────────────────────────────────
        $programsData = [
            ['name' => 'Magang Web Development', 'start_date' => '2026-01-15', 'end_date' => '2026-06-15'],
            // ['name' => 'Magang Mobile App', 'start_date' => '2026-02-01', 'end_date' => '2026-07-31'],
            // ['name' => 'Magang Data Science', 'start_date' => '2026-03-01', 'end_date' => '2026-08-31'],
        ];

        $allPrograms = [];
        foreach ($industries as $industry) {
            foreach ($programsData as $progData) {
                $program = InternshipProgram::firstOrCreate(
                ['industry_id' => $industry->id, 'name' => $progData['name']],
                [
                    'industry_id' => $industry->id,
                    'name' => $progData['name'],
                    'start_date' => $progData['start_date'],
                    'end_date' => $progData['end_date'],
                    'invitation_code' => strtoupper(Str::random(8)),
                    'is_active' => true,
                ]
                );
                $allPrograms[] = $program;
            }
        }

        $this->command->info('✅ Created ' . count($allPrograms) . ' internship programs.');

        // ──────────────────────────────────────────────
        // 4. Student users + Student records
        // ──────────────────────────────────────────────
        $studentsData = [
            ['name' => 'Siswa Andi Pratama', 'email' => 'andi@student.com', 'nis' => 'S2026001', 'class' => 'XII RPL 1', 'hobby' => 'Coding'],
            // ['name' => 'Rina Wulandari', 'email' => 'rina@student.com', 'nis' => 'S2026002', 'class' => 'XII RPL 2', 'hobby' => 'Design'],
            // ['name' => 'Dimas Aditya', 'email' => 'dimas@student.com', 'nis' => 'S2026003', 'class' => 'XII TKJ 1', 'hobby' => 'Networking'],
            // ['name' => 'Putri Amelia', 'email' => 'putri@student.com', 'nis' => 'S2026004', 'class' => 'XII RPL 1', 'hobby' => 'Reading'],
            // ['name' => 'Fajar Nugroho', 'email' => 'fajar@student.com', 'nis' => 'S2026005', 'class' => 'XII MM 1', 'hobby' => 'Photography'],
            // ['name' => 'Lina Sari', 'email' => 'lina@student.com', 'nis' => 'S2026006', 'class' => 'XII RPL 2', 'hobby' => 'Gaming'],
            // ['name' => 'Rizky Hidayat', 'email' => 'rizky@student.com', 'nis' => 'S2026007', 'class' => 'XII TKJ 2', 'hobby' => 'Music'],
            // ['name' => 'Maya Kusuma', 'email' => 'maya@student.com', 'nis' => 'S2026008', 'class' => 'XII MM 1', 'hobby' => 'Drawing'],
            // ['name' => 'Tono Surya', 'email' => 'tono@student.com', 'nis' => 'S2026009', 'class' => 'XII RPL 1', 'hobby' => 'Football'],
            // ['name' => 'Sari Indah', 'email' => 'sari@student.com', 'nis' => 'S2026010', 'class' => 'XII TKJ 1', 'hobby' => 'Swimming'],
        ];

        $allStudents = [];
        foreach ($studentsData as $i => $sData) {
            $user = User::firstOrCreate(
            ['email' => $sData['email']],
            [
                'name' => $sData['name'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
            );

            // Distribute students across programs, schools, supervisors
            $program = $allPrograms[$i % count($allPrograms)];
            $school = $allSchools[$i % count($allSchools)];
            $supervisor = $allSupervisors[$i % count($allSupervisors)];

            $student = Student::firstOrCreate(
            ['user_id' => $user->id],
            [
                'internship_program_id' => $program->id,
                'school_id' => $school->id,
                'school_supervisor_id' => $supervisor->id,
                'nis' => $sData['nis'],
                'class' => $sData['class'],
                'address' => 'Jl. Contoh No. ' . ($i + 1),
                'phone' => '0812000' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'hobby' => $sData['hobby'],
            ]
            );

            $allStudents[] = $student;
        }

        $this->command->info('✅ Created ' . count($allStudents) . ' students.');

        // ──────────────────────────────────────────────
        // 5. Criteria (per industry-school pair)
        // ──────────────────────────────────────────────
        $criteriaNames = [
            ['name' => 'Kedisiplinan', 'description' => 'Ketepatan waktu hadir dan kepatuhan terhadap aturan'],
            ['name' => 'Keterampilan Teknis', 'description' => 'Kemampuan teknis sesuai bidang magang'],
            ['name' => 'Komunikasi', 'description' => 'Kemampuan berkomunikasi dengan tim dan atasan'],
            ['name' => 'Inisiatif', 'description' => 'Kemampuan mengambil inisiatif dalam pekerjaan'],
            ['name' => 'Kerjasama Tim', 'description' => 'Kemampuan bekerja sama dalam tim'],
        ];

        $allCriteria = [];
        foreach ($allSchools as $school) {
            foreach ($criteriaNames as $critData) {
                $criterion = Criterion::firstOrCreate(
                [
                    'industry_id' => $school->industry_id,
                    'school_id' => $school->id,
                    'name' => $critData['name'],
                ],
                ['description' => $critData['description']]
                );
                $allCriteria[] = $criterion;
            }
        }

        $this->command->info('✅ Created ' . count($allCriteria) . ' criteria.');

        // ──────────────────────────────────────────────
        // 6. Grades (per student × matching criteria)
        // ──────────────────────────────────────────────
        $gradeCount = 0;
        foreach ($allStudents as $student) {
            // Get criteria that match the student's school
            $matchingCriteria = collect($allCriteria)->where('school_id', $student->school_id);

            foreach ($matchingCriteria as $criterion) {
                Grade::firstOrCreate(
                [
                    'criteria_id' => $criterion->id,
                    'student_id' => $student->id,
                ],
                [
                    'score' => rand(60, 100),
                ]
                );
                $gradeCount++;
            }
        }

        $this->command->info('✅ Created ' . $gradeCount . ' grades.');

        // ──────────────────────────────────────────────
        // 7. Attendance Sessions
        // ──────────────────────────────────────────────
        $sessionCount = 0;

        foreach ($industries as $industry) {
            $owner = $industry->owner_id;

            // Create sessions for the last 20 working days
            $date = now()->subDays(25);
            for ($d = 0; $d < 1; $d++) {
                // Skip weekends
                if ($date->isWeekend()) {
                    $date->addDay();
                    $d--;
                    continue;
                }

                AttendanceSession::firstOrCreate(
                [
                    'industry_id' => $industry->id,
                    'session_date' => $date->toDateString(),
                ],
                [
                    'opened_by_user_id' => $owner,
                    'on_time_deadline' => '08:00:00',
                    'closed_at' => '17:00:00',
                    'is_open' => false,
                ]
                );
                $sessionCount++;

                $date->addDay();
            }
        }

        $this->command->info('✅ Created ' . $sessionCount . ' attendance sessions.');
        $this->command->info('');
        $this->command->info('🎉 FullDataSeeder completed successfully!');
    }
}