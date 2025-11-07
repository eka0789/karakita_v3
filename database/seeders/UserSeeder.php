<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 🧩 Buat role jika belum ada
        $roles = ['admin', 'pengajar', 'orangtua', 'siswa'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 🧑‍💻 1. Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@karakterkita.org'],
            [
                'name' => 'Administrator KarakterKita',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        $admin->assignRole('admin');

        // 👨‍🏫 2. Data Pengajar
        $teachers = [
            'TK 1' => 'Ervina Khoerunnisa',
            'TK 2' => 'Lilis Risma',
            'Kelas 1' => 'Ervina Khoerunnisa',
            'Kelas 2' => 'Lilis Risma',
            'Kelas 3' => 'Rina Siti Mariam',
            'Kelas 4' => 'Rina Siti Mariam',
            'Kelas 5' => 'Anggun Puji Nurani',
            'Kelas 6' => 'Anggun Puji Nurani',
        ];

        foreach ($teachers as $class => $teacherName) {
            $email = strtolower(str_replace(' ', '', $teacherName)) . '@karakterkita.org';

            $teacher = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $teacherName,
                    'password' => Hash::make('password'),
                    'role' => 'pengajar',
                    'class_assigned' => $class, // optional jika ada kolom class_assigned
                ]
            );

            $teacher->assignRole('pengajar');
        }

        // 👩‍🎓 3. Data Siswa per Kelas
        $students = [
            'TK1' => [
                'Adreena Syaza Nalla Badzlin', 'Alvaro Azril Zalfan', 'Elvani Ayudia Septa', 'Haura Aqila Ghifari',
                'Ibrahim Arsyad Putra', 'Ka\'ab Mauza Dzulka Setiawan', 'Khansa Alnaira Waffiyah', 'Khanza Putri Haryadi',
                'Mahreen Laiba Shaqeena Chaidir', 'Mohammad Alfarizi Aripin', 'Muhammad Raihan Abdurrahman',
                'Niyaz Mizra Ibad', 'Rico Rafif Al-Farizki', 'Shafana Laiba Husna', 'Nadzira Agnia', 'Shaffiya Jannatu Sauqi',
            ],
            'TK2' => [
                'Alif Rizal Hamdillah', 'Amara Lidiya Ningsih', 'Billy Pamungkas', 'Devita Adelia', 'Giovanni Elnathan Bukang',
                'Khabib Fauzan', 'M. Ammar Adnan Ramadhan', 'Muhammad Adam Al Mutaqin', 'Muhammad Fatih Alfarizki',
                'Muhammad Gibran Alhusayn', 'Muhammad Zainal Muttaqiin', 'Radyan Japri Al-Dedu', 'Sayyidina Tsabit Al Fatih',
                'Shaka Rafasqy Ginanjar', 'Zainab Qailula Mumtazah', 'Zayn Fachry Al Fatih',
            ],
            'KLS1' => [
                'Alvaro Maldini Saputra', 'Arvino Yeheezkiel', 'Atha Haffizh Habibillah', 'Azzam Putra Mulyana',
                'Clemira Parveen Basri', 'Dammar Giovino Akbar', 'Delisa Kinara Azzahra', 'Ghisani Hannan Dany',
                'Kiara Anindita Salsabila', 'Kiblan Salim Al-Manafi', 'M. Syakeel Alfarizi', 'Muhammad Hakam Attaya',
                'Muhammad Kenzio Albani', 'Mutiara Berliani', 'Nafisha Queena Athalia', 'Raisya Azzahra Cahyani',
                'Revalina', 'Tefani Azizah',
            ],
            'KLS2' => [
                'Abhizar Putra Darmawan', 'Abil Muhammad Hasbi Rudianto', 'Adhitama Safta Nugraha', 'Alleva velyvia Myesha',
                'Almeera Rahmadhani N.', 'Annisa Zaskia Mecca', 'Arsakha Athallah Nurdiansyah', 'Arshaka Aldric Naldi',
                'Fakhira Dafina Azzahra', 'Farid Pratama Nur Rizky', 'Farrel Hafiz Alfatih', 'Keenan Shaquille Sudrajat',
                'M. Raffa Alfitrah', 'Muhamad Adnan Shakeel', 'Muhammad Arkhan Al Farizy', 'Muhammad Arkhan Raffasya S.',
                'Muhammad Hafidz Dana M.', 'Qianna Putri Almahyra', 'Qianzi Mayla Faisha', 'Quaresma Ramadhan',
                'Qyandra Athalla Shabira', 'Revalia Khayra Setiadi', 'Sabrina Arsyila Kurniawan', 'Satria Dharma Putra',
                'Shehrazat Bilqish Humairah', 'Syakila Putri Salim Hilabi', 'Tanti Maryani',
            ],
            'KLS3' => [
                'Aldrian Sijabat Michael', 'Alicia Amara Kusnadi', 'Alisha Radya Almahya', 'Azril Rahandika Alfariq',
                'Bintang Fauza Fadillah Gunawan', 'Disa Ratu Kirana', 'Elvina Alesha Putri', 'Fahima Aufa',
                'Fariel Atharizz Calief', 'Fazril Muhamad Haikal', 'Hafidzan Hannan HR.', 'Hana Fathiyaturahman',
                'Keyra Dwi Hardiyanti', 'M. Arrasyid Nugraha', 'M. Danendra Al Fatih', 'Muhammad Arkan Fazza',
                'Raihanah Airha Putri', 'Rasya Muhamad Athaya', 'Rifana Khumaira Az Zahra', 'Shakilla Dwi Latiffah',
                'Zhavira Azzahra Solehah',
            ],
            'KLS4' => [
                'M. Alvaro Adnan Kairi', 'Alkhalifi Asrofi Ramdaani', 'Ananda Abyan F', 'Aqifa Azalea Yusuf',
                'Arfan Putra Aditya', 'Arsyila Suharprayasti', 'Bilqis Veraya Alzahra', 'Dinda Afifah',
                'Dzaka Ramadhani Arifin', 'Frissil Aurellia Maulanada', 'Hardjuna Ali', 'Khanza Azalea Farzana',
                'Muhammad Dhika Al-Fatih', 'Nayla Nur Aulia S.', 'Nurul Rahma Fauziah', 'Queenzi Naura Agatha',
                'Rafka Ardiansa', 'Saiful Bahri', 'Shafiqa Khoerunisa', 'Syaqila Ghilsa Hibatillah', 'Tina Syawatul Irawan',
            ],
            'KLS5' => [
                'Anindya Samha Saufa', 'Denissa Nur Rohaniah', 'Endra Agatha Al Zafran', 'Faiz Fauzy',
                'Naura Hasna Annida', 'As\'syofa Nur Kholisah Zivvara', 'Nazriel Daffa', 'Arvian Naufal Arifin',
                'Naufal Abqory Allamah', 'Muhammad Naufal Ardiansyah', 'Muhammad Argha Luthfi Syahlefi',
                'Muhamad Rizky Anugrah',
            ],
        ];

        foreach ($students as $class => $names) {
            foreach ($names as $index => $studentName) {
                $email = strtolower(str_replace(' ', '', $studentName)) . '@karakterkita.org';
                $email = preg_replace('/[^a-z0-9@.]/', '', $email); // bersihkan karakter aneh

                $student = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $studentName,
                        'password' => Hash::make('password'),
                        'role' => 'siswa',
                        'class_assigned' => $class, // optional jika ada kolom class_assigned
                    ]
                );
                $student->assignRole('siswa');
            }
        }

        $this->command->info('✅ Semua data user (admin, guru, siswa) berhasil dibuat.');
    }
}
