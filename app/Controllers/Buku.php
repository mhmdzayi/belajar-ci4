<?php

namespace App\Controllers;

class Buku extends BaseController
{
    /**
     * Halaman daftar buku
     */
    public function index(): string
    {
        $data = [
            'title' => 'Daftar Buku',
            'daftar_buku' => [
                ['id' => 1, 'judul' => 'Clean Code', 'penulis' => 'Robert C. Martin', 'tahun' => 2008, 'kategori' => 'Programming'],
                ['id' => 2, 'judul' => 'Design Patterns', 'penulis' => 'Gang of Four', 'tahun' => 1994, 'kategori' => 'Software Architecture'],
                ['id' => 3, 'judul' => 'The Pragmatic Programmer', 'penulis' => 'Hunt & Thomas', 'tahun' => 2019, 'kategori' => 'Programming'],
                ['id' => 4, 'judul' => 'Refactoring', 'penulis' => 'Martin Fowler', 'tahun' => 2018, 'kategori' => 'Software Engineering'],
                ['id' => 5, 'judul' => 'Code Complete', 'penulis' => 'Steve McConnell', 'tahun' => 2004, 'kategori' => 'Programming'],
            ],
        ];

        return view('buku/index', $data);
    }
}
