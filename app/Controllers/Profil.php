<?php

namespace App\Controllers;

class Profil extends BaseController
{
    /**
     * Halaman profil mahasiswa
     */
    public function index(): string
    {
        $data = [
            'title'       => 'Profil',
            'npm'         => '2310010302',
            'nama'        => 'Muhammad Zaini',
            'prodi'       => 'Teknik Informatika',
            'angkatan'    => '2023',
            'ipk'         => 3.83,
            'mata_kuliah' => [
                'Metodologi Penelitian',
                'Jaringan Syaraf Tiruan',
                'keamanan Sistem Komputer',
                'Sistem Penunjang Keputusan',
                'Citra Digital',
            ],
        ];

        return view('profil/index', $data);
    }
}
