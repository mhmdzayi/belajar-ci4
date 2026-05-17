<?php 
 
namespace App\Controllers; 
 
use App\Models\KategoriModel; 
use App\Models\BukuModel; 
 
class Kategori extends BaseController 
{ 
    private KategoriModel $kategoriModel; 
    private BukuModel $bukuModel; 
 
    public function __construct() 
    { 
        $this->kategoriModel = new KategoriModel(); 
        $this->bukuModel     = new BukuModel(); 
    } 
 
    public function index(): string 
    { 
        $kategori = $this->kategoriModel->getAllWithCounts(); 
        return view('kategori/index', [ 
            'title'    => 'Daftar Kategori', 
            'kategori' => $kategori, 
        ]); 
    } 
 
    public function tambah(): string 
    { 
        return view('kategori/form', [ 
            'title'    => 'Tambah Kategori', 
            'kategori' => null, 
        ]); 
    } 
 
    public function simpan() 
    { 
        $nama = trim($this->request->getPost('nama')); 
        $deskripsi = $this->request->getPost('deskripsi'); 

        if ($nama === '') { 
            session()->setFlashdata('error', 'Nama kategori tidak boleh kosong.'); 
            return redirect()->back()->withInput(); 
        } 

        if ($this->kategoriModel->isNameTaken($nama)) { 
            session()->setFlashdata('error', 'Nama kategori sudah digunakan.'); 
            return redirect()->back()->withInput(); 
        } 

        $this->kategoriModel->insert([ 
            'nama' => $nama, 
            'deskripsi' => $deskripsi, 
        ]); 

        session()->setFlashdata('sukses', "Kategori '{$nama}' berhasil ditambahkan."); 
        return redirect()->to('/kategori'); 
    } 
 
    public function edit(int $id): string 
    { 
        $kat = $this->kategoriModel->find($id); 
        if (!$kat) { 
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan'); 
        } 

        return view('kategori/form', [ 
            'title'    => 'Edit Kategori: ' . $kat['nama'], 
            'kategori' => $kat, 
        ]); 
    } 
 
    public function update(int $id) 
    { 
        $nama = trim($this->request->getPost('nama')); 
        $deskripsi = $this->request->getPost('deskripsi'); 

        if ($nama === '') { 
            session()->setFlashdata('error', 'Nama kategori tidak boleh kosong.'); 
            return redirect()->back()->withInput(); 
        } 

        if ($this->kategoriModel->isNameTaken($nama, $id)) { 
            session()->setFlashdata('error', 'Nama kategori sudah digunakan oleh kategori lain.'); 
            return redirect()->back()->withInput(); 
        } 

        $this->kategoriModel->update($id, [ 
            'nama' => $nama, 
            'deskripsi' => $deskripsi, 
        ]); 

        session()->setFlashdata('sukses', "Kategori '{$nama}' berhasil diperbarui."); 
        return redirect()->to('/kategori'); 
    } 
 
    public function hapus(int $id) 
    { 
        $kat = $this->kategoriModel->find($id); 
        if (!$kat) { 
            session()->setFlashdata('error', 'Kategori tidak ditemukan.'); 
            return redirect()->to('/kategori'); 
        } 

        $jumlah = $this->bukuModel->countByKategori($id); 
        if ($jumlah > 0) { 
            session()->setFlashdata('error', "Kategori '{$kat['nama']}' tidak dapat dihapus karena masih digunakan oleh {$jumlah} buku."); 
            return redirect()->to('/kategori'); 
        } 

        $this->kategoriModel->delete($id); 
        session()->setFlashdata('sukses', "Kategori '{$kat['nama']}' berhasil dihapus."); 
        return redirect()->to('/kategori'); 
    } 
} 
