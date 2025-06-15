<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jamu;
use Carbon\Carbon;

class JamuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('../dataset_jamus.csv');

        if (!file_exists($csvFile)) {
            $this->command->error('CSV file not found at: ' . $csvFile);
            return;
        }

        $handle = fopen($csvFile, 'r');
        $header = fgetcsv($handle, 1000, ';'); // Skip header row

        while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
            if (count($data) >= 9) {
                try {
                    // Parse the expired date
                    $expiredDate = Carbon::createFromFormat('d/m/Y', trim($data[6]));

                    Jamu::create([
                        'nama_jamu' => trim($data[0]),
                        'kategori' => trim($data[1]),
                        'kandungan' => trim($data[2]),
                        'harga' => (float) str_replace(',', '', trim($data[3])),
                        'khasiat' => trim($data[4]),
                        'efek_samping' => trim($data[5]) === 'Tidak ada' ? null : trim($data[5]),
                        'expired_date' => $expiredDate->format('Y-m-d'),
                        'nilai_kandungan' => (int) trim($data[7]),
                        'nilai_khasiat' => (int) trim($data[8]),
                        'deskripsi' => 'Jamu tradisional dengan khasiat ' . strtolower(trim($data[4])),
                        'cara_penggunaan' => 'Diminum 2-3 kali sehari setelah makan',
                        'is_active' => true,
                    ]);
                } catch (\Exception $e) {
                    $this->command->warn('Error importing row: ' . implode(';', $data) . ' - ' . $e->getMessage());
                }
            }
        }

        fclose($handle);
        $this->command->info('Jamu data imported successfully!');
    }
}
