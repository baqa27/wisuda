<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = [
            // Angkatan 2021
            ['nim' => '2021150083', 'name' => 'M.rijal Rizqiawan', 'tahun' => 2021],
            ['nim' => '2021150077', 'name' => 'Nazhif Aqiel Murtadho', 'tahun' => 2021],
            ['nim' => '2021150120', 'name' => 'Muhdin Faizin', 'tahun' => 2021],

            // Angkatan 2022
            ['nim' => '2022150014', 'name' => 'Ridwan Widiyono', 'tahun' => 2022],
            ['nim' => '2022150140', 'name' => 'Figih Roni Mahendra', 'tahun' => 2022],

            // Angkatan 2023
            ['nim' => '2023150001', 'name' => 'Dimas Wahyu Ramadhani', 'tahun' => 2023],
            ['nim' => '2023150009', 'name' => 'Irsyad Oktarian Ramadhandi', 'tahun' => 2023],
            ['nim' => '2023150010', 'name' => 'Wahyu Adji Pratama', 'tahun' => 2023],
            ['nim' => '2023150016', 'name' => 'Awalin Nisa\'ul Mufidah', 'tahun' => 2023],
            ['nim' => '2023150019', 'name' => 'Fatikha Ikmalia', 'tahun' => 2023],
            ['nim' => '2023150020', 'name' => 'Aaisyah Jihan Zakiyah', 'tahun' => 2023],
            ['nim' => '2023150023', 'name' => 'Muhammad Khoirul', 'tahun' => 2023],
            ['nim' => '2023150024', 'name' => 'Asyam Hilmy Wijaya', 'tahun' => 2023],
            ['nim' => '2023150027', 'name' => 'Sofiatun Nisa\'', 'tahun' => 2023],
            ['nim' => '2023150030', 'name' => 'Muhammad Khoirur Rosyid', 'tahun' => 2023],
            ['nim' => '2023150034', 'name' => 'Ahlis Farih Fadli', 'tahun' => 2023],
            ['nim' => '2023150037', 'name' => 'Muhammad Rakha Qushayyi Andrianto', 'tahun' => 2023],
            ['nim' => '2023150041', 'name' => 'Nazilatunikmah', 'tahun' => 2023],
            ['nim' => '2023150044', 'name' => 'Dhea Anggrestyn', 'tahun' => 2023],
            ['nim' => '2023150045', 'name' => 'Audri Nafaza Auralia', 'tahun' => 2023],
            ['nim' => '2023150048', 'name' => 'Taufik Hidayat', 'tahun' => 2023],
            ['nim' => '2023150054', 'name' => 'Tsani Avrilia Nadzifa', 'tahun' => 2023],
            ['nim' => '2023150055', 'name' => 'Zayyana Maulida', 'tahun' => 2023],
            ['nim' => '2023150064', 'name' => 'Kayla Malikha Putri', 'tahun' => 2023],
            ['nim' => '2023150065', 'name' => 'Riskha Suheila Kirmalani', 'tahun' => 2023],
            ['nim' => '2023150066', 'name' => 'Muchamad Azil Muarif', 'tahun' => 2023],
            ['nim' => '2023150069', 'name' => 'Hanif Kurniawan', 'tahun' => 2023],
            ['nim' => '2023150070', 'name' => 'Vania Sifah Masrukhah', 'tahun' => 2023],
            ['nim' => '2023150076', 'name' => 'Adi Kusuma Udin', 'tahun' => 2023],
            ['nim' => '2023150078', 'name' => 'Rizky Ramadhan', 'tahun' => 2023],
            ['nim' => '2023150080', 'name' => 'M.Syamsul Ma\'arif', 'tahun' => 2023],
            ['nim' => '2023150082', 'name' => 'Muhammad Rafi Dzaki Afkar', 'tahun' => 2023],
            ['nim' => '2023150084', 'name' => 'Arya Ulya Prasetya', 'tahun' => 2023],
            ['nim' => '2023150092', 'name' => 'Adif Saputra', 'tahun' => 2023],
            ['nim' => '2023150094', 'name' => 'Titi Alfiana Pramesti', 'tahun' => 2023],
            ['nim' => '2023150096', 'name' => 'Kresna Eka Wilianto', 'tahun' => 2023],
            ['nim' => '2023150099', 'name' => 'David Febrian Saputra', 'tahun' => 2023],
            ['nim' => '2023150102', 'name' => 'Akhmad Khadziq Khafifi', 'tahun' => 2023],
            ['nim' => '2023150103', 'name' => 'Ida Masruroh', 'tahun' => 2023],
            ['nim' => '2023150105', 'name' => 'Muhammad Rayhan Aly Kahrayman', 'tahun' => 2023],
            ['nim' => '2023150106', 'name' => 'Muhammad Irvan Asy\'ari', 'tahun' => 2023],
            ['nim' => '2023150108', 'name' => 'Muhammad Sultan Baqa', 'tahun' => 2023],
            ['nim' => '2023150109', 'name' => 'Muhammad Nabil Al Faqih', 'tahun' => 2023],
            ['nim' => '2023150112', 'name' => 'Fadli Novan Ramadhani', 'tahun' => 2023],
            ['nim' => '2023150113', 'name' => 'Muhamad Farhan Aridho', 'tahun' => 2023],
            ['nim' => '2023150114', 'name' => 'Ahmad Irfan', 'tahun' => 2023],
            ['nim' => '2023150115', 'name' => 'Lukman Mas', 'tahun' => 2023],
            ['nim' => '2023150118', 'name' => 'Titan Attariq Al Fata', 'tahun' => 2023],
            ['nim' => '2023150129', 'name' => 'Helmi Setiawan', 'tahun' => 2023],
            ['nim' => '2023150134', 'name' => 'Rafael Ikhbar Febriansyah', 'tahun' => 2023],
            ['nim' => '2023150137', 'name' => 'Raihan Bagas Dwiputra', 'tahun' => 2023],
            ['nim' => '2023150138', 'name' => 'Az-zahrawani', 'tahun' => 2023],
            ['nim' => '2023150142', 'name' => 'Ahmad Nafa Bagus Munawar', 'tahun' => 2023],
            ['nim' => '2023150146', 'name' => 'Arif Rohman Karim', 'tahun' => 2023],
            ['nim' => '2023150151', 'name' => 'Mahdi Pandu Mahardika', 'tahun' => 2023],
            ['nim' => '2023150160', 'name' => 'Kurniawan Dwi Cahyo', 'tahun' => 2023],
            ['nim' => '2023150165', 'name' => 'Lisdayanti Motoredjo', 'tahun' => 2023],
            ['nim' => '2023150167', 'name' => 'Yuliati Imud', 'tahun' => 2023],
        ];

        // Random IPK values for variety
        $ipkOptions = [3.00, 3.15, 3.25, 3.35, 3.45, 3.50, 3.55, 3.60, 3.65, 3.70, 3.75, 3.80, 3.85, 3.90, 3.95];

        foreach ($mahasiswa as $index => $mhs) {
            // Generate email from NIM
            $email = strtolower($mhs['nim']) . '@student.wisuda.ac.id';
            
            // Random IPK
            $ipk = $ipkOptions[array_rand($ipkOptions)];
            
            // Random phone number
            $phone = '08' . rand(11, 99) . rand(1000000, 9999999);

            User::updateOrCreate(
                ['nim' => $mhs['nim']], // Unique key to prevent duplicates
                [
                    'name' => $mhs['name'],
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'mahasiswa',
                    'prodi' => 'Teknik Informatika',
                    'ipk' => $ipk,
                    'no_hp' => $phone,
                    'semester' => $mhs['tahun'] == 2021 ? 8 : ($mhs['tahun'] == 2022 ? 6 : 4),
                ]
            );
        }

        $this->command->info('✅ ' . count($mahasiswa) . ' mahasiswa berhasil ditambahkan!');
    }
}
