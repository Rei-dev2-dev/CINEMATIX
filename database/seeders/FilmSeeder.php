<?php
// database/seeders/FilmSeeder.php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Film;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nowShowing = [
            [
                'title' => 'Gak Ada Matinya',
                'genre' => 'Komedi / Aksi',
                'duration' => 95,
                'rating' => 4.6,
                'age_rating' => '13+',
                'director' => 'Ody Harahap',
                'cast' => 'Boris Bokir, Gita Bhebhita, Indra Jegel',
                'synopsis' => 'Petualangan jenaka dua sahabat pencari nafkah di sudut kota metropolitan yang bertekad membuktikan bahwa semangat persahabatan sejati takkan pernah ada matinya meski cobaan silih berganti.',
                'poster_url' => 'images/Sedang_Tayang/Gak ada matinya.jpg',
                'banner_url' => 'images/Sedang_Tayang/ketik_film-gak-ada-matinya_thumbnail.png',
                'trailer_url' => 'https://youtu.be/3bfHbG5WKr4?si=w3Kj2CEoDedifTCH',
                'status' => 'now_showing',
                'is_featured' => true,
                'release_date' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'GJLS: Berapi-Api',
                'genre' => 'Komedi / Petualangan',
                'duration' => 104,
                'rating' => 4.7,
                'age_rating' => '13+',
                'director' => 'Rigen Rakelna',
                'cast' => 'Rigen, Ananta Rispo, Hifdzi Khoir',
                'synopsis' => 'Trio GJLS terjebak dalam misi penyelamatan warisan misterius yang membawa mereka berhadapan dengan geng lokal paling absurd di tanah Jawa.',
                'poster_url' => 'images/Sedang_Tayang/gjls berapi api.jpg',
                'banner_url' => 'images/Sedang_Tayang/gjls berapi api_thumbnail.png',
                'trailer_url' => 'https://youtu.be/xBhZnZTHOZo?si=ykVf6vrwEm_mjZj_',
                'status' => 'now_showing',
                'is_featured' => false,
                'release_date' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Godzilla Minus One',
                'genre' => 'Aksi / Sci-Fi',
                'duration' => 125,
                'rating' => 4.9,
                'age_rating' => '13+',
                'director' => 'Takashi Yamazaki',
                'cast' => 'Ryunosuke Kamiki, Minami Hamabe',
                'synopsis' => 'Di tengah kehancuran pasca-perang di Jepang, ancaman raksasa purba Godzilla muncul dari samudra Pasifik dan menghancurkan sisa-sisa harapan manusia.',
                'poster_url' => 'images/Sedang_Tayang/GODZILLA.jpg',
                'banner_url' => 'images/Sedang_Tayang/godzilla-minus-zero-thumnail.jpg',
                'trailer_url' => 'https://youtu.be/0zrIMIcsT0k?si=bgp87HWybfOLwR3x',
                'status' => 'now_showing',
                'is_featured' => false,
                'release_date' => Carbon::now()->subDays(8),
            ],
            [
                'title' => 'Laut Bercerita',
                'genre' => 'Drama / Sejarah',
                'duration' => 110,
                'rating' => 4.8,
                'age_rating' => '17+',
                'director' => 'Pritagita Arianegara',
                'cast' => 'Reza Rahadian, Dian Sastrowardoyo, Ayushita',
                'synopsis' => 'Kisah para aktivis mahasiswa yang dihilangkan secara paksa dan jeritan hati keluarga yang tak pernah berhenti mencari kepastian nasib sanak saudaranya.',
                'poster_url' => 'images/Sedang_Tayang/Laut Bercerita.jpg',
                'banner_url' => 'images/Sedang_Tayang/poster-film-laut-bercerita-thumbnail.jpg',
                'trailer_url' => 'https://youtu.be/Crx2f2CvUpc?si=5qpNztd_vzQRoEEx',
                'status' => 'now_showing',
                'is_featured' => false,
                'release_date' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'Pirunduk',
                'genre' => 'Drama / Misteri',
                'duration' => 100,
                'rating' => 4.4,
                'age_rating' => '13+',
                'director' => 'Budi Santoso',
                'cast' => 'Adipati Dolken, Shenina Cinnamon',
                'synopsis' => 'Di balik rindangnya pedalaman hutan tropis, seorang pemuda menelusuri legenda leluhur tentang kabut mistis dan sumpah suci yang menjaga kedamaian alam.',
                'poster_url' => 'images/Sedang_Tayang/pirunduk.jpg',
                'banner_url' => 'images/Sedang_Tayang/Pirunduk_thumbnail.jpg',
                'trailer_url' => 'https://youtu.be/Zn1CqB2eVUM?si=wcMbRy59dKNF1Q3F',
                'status' => 'now_showing',
                'is_featured' => false,
                'release_date' => Carbon::now()->subDays(12),
            ],
            [
                'title' => 'Ramayana: The Legend of Prince Rama',
                'genre' => 'Animasi / Epik',
                'duration' => 135,
                'rating' => 4.9,
                'age_rating' => 'SU',
                'director' => 'Yugo Sako, Ram Mohan',
                'cast' => 'Arun Govil, Nikhil Kapoor',
                'synopsis' => 'Epos agung tentang Pangeran Rama yang mengarungi samudra dan memimpin pasukan kera untuk membebaskan Dewi Sita dari cengkeraman Raja Rahwana.',
                'poster_url' => 'images/Sedang_Tayang/Ramayana.jpg',
                'banner_url' => 'images/Sedang_Tayang/Hindi_Trailer_Thumbnail_1280x720_1.png',
                'trailer_url' => 'https://youtu.be/djmh9ca-Ibg?si=hRHYUPf5OyoP0sDz',
                'status' => 'now_showing',
                'is_featured' => false,
                'release_date' => Carbon::now()->subDays(14),
            ],
            [
                'title' => 'The Cat in the Hat',
                'genre' => 'Animasi / Keluarga',
                'duration' => 92,
                'rating' => 4.3,
                'age_rating' => 'SU',
                'director' => 'Erica Rivinoja, Alessandro Carloni',
                'cast' => 'Bill Hader, Quinta Brunson, Bowen Yang',
                'synopsis' => 'Kucing jenaka bertopi merah putih membawa keceriaan dan kekacauan tak terduga ke rumah dua anak yang sedang merasa bosan di tengah hari hujan.',
                'poster_url' => 'images/Sedang_Tayang/the cat in the hat.jpg',
                'banner_url' => 'images/Sedang_Tayang/CATHAT_THUMBNAIL.png',
                'trailer_url' => 'https://youtu.be/HT5JAp5z0-o?si=A-pXQ4LAlFB_vtRS',
                'status' => 'now_showing',
                'is_featured' => false,
                'release_date' => Carbon::now()->subDays(2),
            ],
        ];

        $comingSoon = [
            [
                'title' => 'Avengers: Doomsday',
                'genre' => 'Aksi / Sci-Fi',
                'duration' => 155,
                'rating' => 4.9,
                'age_rating' => '13+',
                'director' => 'Anthony Russo, Joe Russo',
                'cast' => 'Robert Downey Jr., Pedro Pascal, Vanessa Kirby',
                'synopsis' => 'Ancaman multiverse terbesar datang saat Victor von Doom mengumpulkan artefak terlarang demi mendominasi seluruh realitas semesta.',
                'poster_url' => 'images/Segera_Hadir/Avanger-Doomsdays.jpg',
                'banner_url' => 'images/Segera_Hadir/Avanger-Doomsdays_thumbnail.jpg',
                'trailer_url' => 'https://youtu.be/irVNGjRFZGk?si=G_X4htBl2ApKNJ9R',
                'status' => 'coming_soon',
                'is_featured' => false,
                'release_date' => Carbon::create(2026, 12, 18),
            ],
            [
                'title' => 'Seporsi Mie Ayam Sebelum Mati',
                'genre' => 'Drama / Komedi',
                'duration' => 108,
                'rating' => 4.5,
                'age_rating' => '13+',
                'director' => 'Fajar Nugros',
                'cast' => 'Vino G. Bastian, Laura Basuki',
                'synopsis' => 'Kisah hangat tentang pencarian rasa dan makna hidup melalui semangkuk mie ayam legendaris di pinggiran kota sebelum hari terakhir di tahun ini.',
                'poster_url' => 'images/Segera_Hadir/Seporsi_mie Ayam.jpg',
                'banner_url' => 'images/Segera_Hadir/Seporsi_mie Ayam_Thumdnail.jpg',
                'trailer_url' => 'https://youtu.be/Jg7HazKFVNU?si=7mCqrnDjGPPJpMXC',
                'status' => 'coming_soon',
                'is_featured' => false,
                'release_date' => Carbon::create(2026, 11, 12),
            ],
        ];

        $today = Carbon::today();
        $targetScheduleForDemo = null;

        // Seed now showing films with schedules
        foreach ($nowShowing as $data) {
            $data['slug'] = Str::slug($data['title']);
            $film = Film::create($data);

            // Dummy schedules: 2 studios, multiple times starting today
            $studios = [
                [
                    'name' => 'Studio 1',
                    'type' => 'Reguler',
                    'price' => 45000,
                    'times' => ['13.00', '16.15', '19.30', '21.45'],
                ],
                [
                    'name' => 'Studio 2',
                    'type' => 'Premiere',
                    'price' => 65000,
                    'times' => ['14.00', '18.00', '19:00'],
                ],
            ];

            foreach ($studios as $studio) {
                foreach ($studio['times'] as $time) {
                    $schedule = Schedule::create([
                        'film_id' => $film->id,
                        'studio_name' => $studio['name'],
                        'studio_type' => $studio['type'],
                        'show_date' => $today,
                        'show_time' => $time,
                        'price' => $studio['price'],
                    ]);

                    if ($film->is_featured && $studio['name'] === 'Studio 1' && $time === '16.15') {
                        $targetScheduleForDemo = $schedule;
                    }
                }
            }
        }

        // Seed coming soon films (no schedules)
        foreach ($comingSoon as $data) {
            $data['slug'] = Str::slug($data['title']);
            Film::create($data);
        }

        // Create sample booked seats matching the design requirement
        if ($targetScheduleForDemo) {
            $booking1 = Booking::create([
                'booking_code' => 'CNX-SAMPLE1',
                'schedule_id' => $targetScheduleForDemo->id,
                'customer_name' => 'Dimas Prasetyo',
                'customer_email' => 'dimas@example.com',
                'customer_phone' => '081234567890',
                'total_price' => $targetScheduleForDemo->price * 5,
                'status' => 'confirmed',
            ]);

            foreach (['A2', 'A3', 'D2', 'D7', 'C7'] as $seat) {
                BookingSeat::create([
                    'booking_id' => $booking1->id,
                    'schedule_id' => $targetScheduleForDemo->id,
                    'seat_number' => $seat,
                ]);
            }

            // Also create the exact demo booking CNX-7K2Q9 for ticket verification
            $booking2 = Booking::create([
                'booking_code' => 'CNX-7K2Q9',
                'schedule_id' => $targetScheduleForDemo->id,
                'customer_name' => 'Budi Santoso',
                'customer_email' => 'budi.santoso@email.com',
                'customer_phone' => '081298765432',
                'total_price' => $targetScheduleForDemo->price * 2,
                'status' => 'confirmed',
            ]);

            foreach (['C3', 'C4'] as $seat) {
                BookingSeat::create([
                    'booking_id' => $booking2->id,
                    'schedule_id' => $targetScheduleForDemo->id,
                    'seat_number' => $seat,
                ]);
            }
        }
    }
}
