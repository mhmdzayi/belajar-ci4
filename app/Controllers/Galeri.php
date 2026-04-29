<?php

namespace App\Controllers;

class Galeri extends BaseController
{
    /**
     * Halaman galeri dengan filter kategori
     */
    public function index(): string
    {
        // Data galeri statis
        $galeri = [
            [
                'judul' => 'Pemandangan Gunung',
                'url_gambar' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=300&h=200&fit=crop',
                'deskripsi' => 'Pemandangan indah gunung dengan hutan hijau yang luas dan sungai yang mengalir tenang di bawahnya.',
                'kategori' => 'alam'
            ],
            [
                'judul' => 'Kota Modern',
                'url_gambar' => 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=300&h=200&fit=crop',
                'deskripsi' => 'Gedung pencakar langit dan jalan raya yang ramai di pusat kota metropolitan.',
                'kategori' => 'kota'
            ],
            [
                'judul' => 'Hewan Liar',
                'url_gambar' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=300&h=200&fit=crop',
                'deskripsi' => 'Singa yang sedang beristirahat di savana Afrika dengan latar belakang padang rumput yang luas.',
                'kategori' => 'hewan'
            ],
            [
                'judul' => 'Pantai Tropis',
                'url_gambar' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=300&h=200&fit=crop',
                'deskripsi' => 'Pantai dengan pasir putih, air laut biru jernih, dan pohon kelapa yang bergoyang ditiup angin.',
                'kategori' => 'alam'
            ],
            [
                'judul' => 'Arsitektur Kuno',
                'url_gambar' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=300&h=200&fit=crop',
                'deskripsi' => 'Bangunan bersejarah dengan arsitektur klasik yang masih berdiri kokoh hingga saat ini.',
                'kategori' => 'kota'
            ],
            [
                'judul' => 'Burung Eksotis',
                'url_gambar' => 'https://images.unsplash.com/photo-1444464666168-49d633b86797?w=300&h=200&fit=crop',
                'deskripsi' => 'Burung dengan bulu berwarna-warni yang sedang terbang bebas di langit biru.',
                'kategori' => 'hewan'
            ],
        ];

        // Baca parameter kategori dari URL
        $kategori_filter = $this->request->getGet('kategori');

        // Filter galeri berdasarkan kategori jika ada
        if ($kategori_filter && $kategori_filter !== 'semua') {
            $galeri = array_filter($galeri, function($item) use ($kategori_filter) {
                return $item['kategori'] === $kategori_filter;
            });
        }

        // Ambil daftar kategori unik
        $kategori_unik = array_unique(array_column($galeri, 'kategori'));

        $data = [
            'title' => 'Galeri',
            'galeri' => $galeri,
            'kategori_unik' => $kategori_unik,
            'kategori_aktif' => $kategori_filter ?: 'semua',
        ];

        return view('galeri/index', $data);
    }
}
