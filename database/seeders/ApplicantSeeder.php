<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $trainings = Training::all();

        if ($trainings->isEmpty()) {
            $this->command->warn('No trainings found. Please run TrainingSeeder first.');
            return;
        }

        $applicants = [
            [
                'name' => 'John Smith',
                'personal_id' => '01001234567',
                'phone' => '+995555123456',
                'certificate_number' => 'CERT-2023-001',
                'certificate_date' => '2023-06-15',
                'specialty' => 'Marketing Specialist',
                'work_place' => 'Digital Solutions Ltd',
                'work_place_address' => '123 Rustaveli Avenue, Tbilisi, Georgia',
            ],
            [
                'name' => 'Maria Georgescu',
                'personal_id' => '01001234568',
                'phone' => '+995555234567',
                'certificate_number' => 'CERT-2023-002',
                'certificate_date' => '2023-08-20',
                'specialty' => 'Project Manager',
                'work_place' => 'Tech Innovations Inc',
                'work_place_address' => '456 Freedom Square, Tbilisi, Georgia',
            ],
            [
                'name' => 'David Wilson',
                'personal_id' => '01001234569',
                'phone' => '+995555345678',
                'certificate_number' => null,
                'certificate_date' => null,
                'specialty' => 'Data Analyst',
                'work_place' => 'Analytics Pro',
                'work_place_address' => '789 Chavchavadze Avenue, Tbilisi, Georgia',
            ],
            [
                'name' => 'Ana Tediashvili',
                'personal_id' => '01001234570',
                'phone' => '+995555456789',
                'certificate_number' => 'CERT-2024-003',
                'certificate_date' => '2024-01-10',
                'specialty' => 'Team Leader',
                'work_place' => 'Leadership Consulting',
                'work_place_address' => '321 Agmashenebeli Avenue, Tbilisi, Georgia',
            ],
            [
                'name' => 'Michael Brown',
                'personal_id' => '01001234571',
                'phone' => '+995555567890',
                'certificate_number' => 'CERT-2023-004',
                'certificate_date' => '2023-11-05',
                'specialty' => 'Web Developer',
                'work_place' => 'Code Masters LLC',
                'work_place_address' => '654 Pekini Avenue, Tbilisi, Georgia',
            ],
            [
                'name' => 'Nino Beridze',
                'personal_id' => '01001234572',
                'phone' => '+995555678901',
                'certificate_number' => null,
                'certificate_date' => null,
                'specialty' => 'Marketing Assistant',
                'work_place' => 'Creative Agency',
                'work_place_address' => '987 Kostava Street, Tbilisi, Georgia',
            ],
            [
                'name' => 'Robert Johnson',
                'personal_id' => '01001234573',
                'phone' => '+995555789012',
                'certificate_number' => 'CERT-2024-005',
                'certificate_date' => '2024-02-28',
                'specialty' => 'Business Analyst',
                'work_place' => 'Strategic Solutions',
                'work_place_address' => '147 Barnovi Street, Tbilisi, Georgia',
            ],
            [
                'name' => 'Tamar Kvaratskhelia',
                'personal_id' => '01001234574',
                'phone' => '+995555890123',
                'certificate_number' => 'CERT-2023-006',
                'certificate_date' => '2023-09-12',
                'specialty' => 'HR Specialist',
                'work_place' => 'Human Resources Pro',
                'work_place_address' => '258 Vazha-Pshavela Avenue, Tbilisi, Georgia',
            ],
        ];

        // Distribute applicants across different trainings
        foreach ($applicants as $index => $applicantData) {
            $training = $trainings[$index % $trainings->count()];
            
            // Check if training has available places
            if ($training->available_places > 0) {
                Applicant::create(array_merge($applicantData, [
                    'training_id' => $training->id,
                ]));
            }
        }
    }
}
