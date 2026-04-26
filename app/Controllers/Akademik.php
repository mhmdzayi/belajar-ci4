<?php

namespace App\Controllers;

class Akademik extends BaseController
{
    // Method 1: Halaman Utama Akademik
    public function index(): string
    {
        return "<h1>Sistem Informasi Akademik</h1>
                <p>Nama Mahasiswa: Muhammad Zaini</p>";
    }

    // Method 2: Daftar Mata Kuliah (Format List HTML)
    public function matkul(): string
    {
        return "<h1>Mata Kuliah Semester Ini</h1>
                <ul>
                    <li>Metodologi Penelitian</li>
                    <li>Jaringan Syaraf Tiruan</li>
                    <li>Keamanan Sistem Komputer</li>
                    <li>Sistem Penunjang Keputusan</li>
                    <li>Citra Digital</li>
                </ul>";
    }

    // Method 3: Cek Nilai dengan Parameter NIM
    public function nilai($nim = ''): string
    {
        return "<h1>Cek Nilai</h1><p>Nilai mahasiswa dengan NIM: {$nim}</p>";
    }
}