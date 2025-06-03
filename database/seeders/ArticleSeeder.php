<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user first if not exists
        $admin = User::firstOrCreate([
            'email' => 'admin@spkjamu.com'
        ], [
            'name' => 'Admin SPK Jamu',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $articles = [
            [
                'title' => 'Mengenal Jamu Tradisional Madura dan Khasiatnya',
                'category' => 'Pengetahuan Jamu',
                'excerpt' => 'Jamu Madura memiliki keunikan tersendiri dengan ramuan tradisional yang telah turun temurun.',
                'content' => '
                <h2>Sejarah Jamu Madura</h2>
                <p>Jamu Madura telah menjadi bagian integral dari kehidupan masyarakat Madura selama berabad-abad. Tradisi pembuatan jamu ini diwariskan secara turun-temurun dari generasi ke generasi.</p>
                
                <h2>Bahan-Bahan Utama</h2>
                <ul>
                    <li><strong>Kunyit:</strong> Berkhasiat sebagai anti-inflamasi dan antioksidan</li>
                    <li><strong>Jahe:</strong> Membantu pencernaan dan menghangatkan tubuh</li>
                    <li><strong>Kencur:</strong> Mengatasi masuk angin dan meningkatkan nafsu makan</li>
                    <li><strong>Temulawak:</strong> Menjaga kesehatan hati dan meningkatkan stamina</li>
                </ul>
                
                <h2>Manfaat untuk Kesehatan</h2>
                <p>Jamu Madura terbukti efektif untuk berbagai kondisi kesehatan seperti meningkatkan daya tahan tubuh, melancarkan pencernaan, dan menjaga kesehatan secara keseluruhan.</p>
                '
            ],
            [
                'title' => 'Tips Memilih Jamu yang Tepat untuk Kondisi Kesehatan Anda',
                'category' => 'Tips Kesehatan',
                'excerpt' => 'Panduan lengkap untuk memilih jamu yang sesuai dengan kebutuhan kesehatan Anda.',
                'content' => '
                <h2>Kenali Kondisi Kesehatan Anda</h2>
                <p>Sebelum memilih jamu, penting untuk memahami kondisi kesehatan dan kebutuhan tubuh Anda saat ini.</p>
                
                <h2>Pertimbangan Penting</h2>
                <ul>
                    <li>Riwayat alergi terhadap bahan tertentu</li>
                    <li>Kondisi kesehatan yang sedang dialami</li>
                    <li>Obat-obatan yang sedang dikonsumsi</li>
                    <li>Usia dan kondisi fisik</li>
                </ul>
                
                <h2>Jamu untuk Berbagai Kondisi</h2>
                <h3>Untuk Meningkatkan Stamina</h3>
                <p>Pilih jamu yang mengandung jahe, temulawak, dan ginseng.</p>
                
                <h3>Untuk Pencernaan</h3>
                <p>Jamu dengan kandungan kunyit, kencur, dan sambiloto sangat efektif.</p>
                '
            ],
            [
                'title' => 'Cara Konsumsi Jamu yang Benar dan Aman',
                'category' => 'Tips Kesehatan',
                'excerpt' => 'Pelajari cara mengonsumsi jamu dengan benar untuk mendapatkan manfaat maksimal.',
                'content' => '
                <h2>Waktu Konsumsi yang Tepat</h2>
                <p>Konsumsi jamu sebaiknya dilakukan pada waktu yang tepat untuk mendapatkan manfaat optimal.</p>
                
                <h2>Dosis yang Dianjurkan</h2>
                <ul>
                    <li>Jamu cair: 1-2 gelas per hari</li>
                    <li>Jamu serbuk: 1-2 sendok teh per takaran</li>
                    <li>Jamu kapsul: Sesuai petunjuk kemasan</li>
                </ul>
                
                <h2>Hal yang Perlu Dihindari</h2>
                <p>Jangan mengonsumsi jamu bersamaan dengan obat kimia tanpa konsultasi dokter. Hindari juga konsumsi berlebihan.</p>
                '
            ],
            [
                'title' => 'Efek Samping Jamu dan Cara Mengatasinya',
                'category' => 'Keamanan',
                'excerpt' => 'Memahami efek samping yang mungkin timbul dari konsumsi jamu dan cara mengatasinya.',
                'content' => '
                <h2>Efek Samping Umum</h2>
                <p>Meskipun alami, jamu tetap dapat menimbulkan efek samping pada sebagian orang.</p>
                
                <h2>Efek Samping yang Sering Terjadi</h2>
                <ul>
                    <li>Mual ringan</li>
                    <li>Pusing</li>
                    <li>Mengantuk</li>
                    <li>Alergi kulit</li>
                </ul>
                
                <h2>Cara Mengatasi</h2>
                <p>Jika mengalami efek samping ringan, hentikan konsumsi sementara dan konsultasikan dengan ahli herbal atau dokter.</p>
                '
            ]
        ];

        foreach ($articles as $articleData) {
            Article::create([
                'title' => $articleData['title'],
                'slug' => Str::slug($articleData['title']),
                'excerpt' => $articleData['excerpt'],
                'content' => $articleData['content'],
                'category' => $articleData['category'],
                'is_published' => true,
                'published_at' => now(),
                'author_id' => $admin->id,
            ]);
        }

        $this->command->info('Articles seeded successfully!');
    }
}
