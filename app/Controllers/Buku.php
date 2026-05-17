<?php 
  
namespace App\Controllers; 
  
use App\Models\BukuModel; 
use App\Models\KategoriModel; 
  
class Buku extends BaseController 
{ 
    private BukuModel $bukuModel; 
    private KategoriModel $kategoriModel; 
  
    public function __construct() 
    { 
        $this->bukuModel     = new BukuModel(); 
        $this->kategoriModel = new KategoriModel(); 
    } 
  
    // ────────────────────────────────────── 
    // READ - Daftar Buku dengan Search & Paginasi 
    // ────────────────────────────────────── 
    public function index(): string 
    { 
        $keyword  = $this->request->getGet('q') ?? ''; 
        $perPage  = 10; 
        $buku     = $this->bukuModel->getBukuPaginate($perPage, $keyword); 
        $pager    = $this->bukuModel->pager; 
  
        $data = [ 
            'title'   => 'Daftar Buku', 
            'buku'    => $buku, 
            'pager'   => $pager, 
            'keyword' => $keyword, 
            'total'   => $this->bukuModel->countAllResults(false), 
        ]; 
        return view('buku/index', $data); 
    } 
  
    // ────────────────────────────────────── 
    // READ - Detail satu buku 
    // ────────────────────────────────────── 
    public function detail(int $id): string 
    { 
        $buku = $this->bukuModel 
            ->select('buku.*, kategori.nama AS nama_kategori') 
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left') 
            ->find($id); 
  
        if (!$buku) { 
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak 
ditemukan'); 
        } 
  
        return view('buku/detail', ['title' => 'Detail Buku', 'buku' => $buku]); 
 } 
  
    // ────────────────────────────────────── 
    // CREATE - Form tambah 
    // ────────────────────────────────────── 
    public function tambah(): string 
    { 
        return view('buku/form', [ 
            'title'     => 'Tambah Buku', 
            'buku'      => null, 
            'kategori'  => $this->kategoriModel->getDropdown(), 
        ]); 
    } 
  
    // ────────────────────────────────────── 
    // CREATE - Proses simpan 
    // ────────────────────────────────────── 
    public function simpan() 
    { 
        $data = $this->ambilDataForm(); 
  
        // Validasi kode unik 
        if ($this->bukuModel->isKodeTaken($data['kode_buku'])) { 
            session()->setFlashdata('error', 'Kode buku sudah digunakan.'); 
            return redirect()->back()->withInput(); 
        } 
  
        $this->bukuModel->insert($data); 
        session()->setFlashdata('sukses', "Buku '{$data['judul']}' berhasil 
ditambahkan."); 
        return redirect()->to('/buku'); 
    } 
  
    // ────────────────────────────────────── 
    // UPDATE - Form edit 
    // ────────────────────────────────────── 
    public function edit(int $id): string 
    { 
        $buku = $this->bukuModel->find($id); 
        if (!$buku) { 
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak 
ditemukan'); 
        } 
  
        return view('buku/form', [ 
            'title'    => 'Edit Buku: ' . $buku['judul'], 
            'buku'     => $buku, 
            'kategori' => $this->kategoriModel->getDropdown(), 
        ]); 
    } 
  
    // ────────────────────────────────────── 
    // UPDATE - Proses update 
    // ────────────────────────────────────── 
    public function update(int $id) 
    { 
        $data = $this->ambilDataForm(); 
  
        // Validasi kode unik, kecuali buku yang sedang diedit
         if ($this->bukuModel->isKodeTaken($data['kode_buku'], $id)) { 
            session()->setFlashdata('error', 'Kode buku sudah digunakan buku lain.'); 
            return redirect()->back()->withInput(); 
        } 
  
        $this->bukuModel->update($id, $data); 
        session()->setFlashdata('sukses', "Buku '{$data['judul']}' berhasil 
diperbarui."); 
        return redirect()->to('/buku'); 
    } 
  
    // ────────────────────────────────────── 
    // DELETE 
    // ────────────────────────────────────── 
    public function hapus(int $id) 
    { 
        $buku = $this->bukuModel->find($id); 
        if (!$buku) { 
            session()->setFlashdata('error', 'Buku tidak ditemukan.'); 
            return redirect()->to('/buku'); 
        } 
  
        $this->bukuModel->delete($id); 
        session()->setFlashdata('sukses', "Buku '{$buku['judul']}' berhasil 
dihapus."); 
        return redirect()->to('/buku'); 
    } 
  
    // ────────────────────────────────────── 
    // PRIVATE HELPER - Kumpulkan data dari form 
    // ────────────────────────────────────── 
    // ──────────────────────────────────────
    // EXPORT - Ekspor buku ke CSV
    // ──────────────────────────────────────
    public function ekspor()
    {
        $keyword = $this->request->getGet('q') ?? '';

        if (!empty($keyword)) {
            $list = $this->bukuModel->cari($keyword);
        } else {
            $list = $this->bukuModel->getBukuDenganKategori();
        }

        $filename = 'buku-export-' . date('Y-m-d') . '.csv';

        $fp = fopen('php://memory', 'w+');

        // Header CSV sesuai ketentuan
        fputcsv($fp, ['No', 'Kode', 'Judul', 'Penulis', 'Penerbit', 'Tahun', 'Stok', 'Kategori']);

        foreach ($list as $i => $b) {
            fputcsv($fp, [
                $i + 1,
                $b['kode_buku'] ?? '',
                $b['judul'] ?? '',
                $b['penulis'] ?? '',
                $b['penerbit'] ?? '',
                $b['tahun'] ?? '',
                $b['stok'] ?? '',
                $b['nama_kategori'] ?? '',
            ]);
        }

        rewind($fp);
        $csv = stream_get_contents($fp);
        fclose($fp);

        return $this->response
            ->setContentType('text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($csv);
    }

    // ──────────────────────────────────────
    // STATISTIK - Tampilkan statistik buku
    // ──────────────────────────────────────
    public function statistik(): string
    {
        $stats = $this->bukuModel->getStatistik();

        $db = \Config\Database::connect();

        // Top 5 buku berdasarkan stok terbanyak
        $top5 = $db->table('buku')
            ->select('buku.judul, buku.stok, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
            ->orderBy('buku.stok', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // Buku dengan stok 0
        $zeroStock = $this->bukuModel
            ->select('buku.id, buku.judul, buku.stok, kategori.nama AS nama_kategori')
            ->join('kategori', 'kategori.id = buku.kategori_id', 'left')
            ->where('buku.stok', 0)
            ->orderBy('buku.judul', 'ASC')
            ->findAll();

        return view('buku/statistik', [
            'title'     => 'Statistik Buku',
            'stats'     => $stats,
            'top5'      => $top5,
            'zeroStock' => $zeroStock,
        ]);
    }

    private function ambilDataForm(): array 
    { 
        return [ 
            'kode_buku'   => strtoupper($this->request->getPost('kode_buku')), 
            'judul'       => $this->request->getPost('judul'), 
            'penulis'     => $this->request->getPost('penulis'), 
            'penerbit'    => $this->request->getPost('penerbit'), 
            'tahun'       => $this->request->getPost('tahun') ?: null, 
            'isbn'        => $this->request->getPost('isbn'), 
            'deskripsi'   => $this->request->getPost('deskripsi'), 
            'stok'        => (int) $this->request->getPost('stok'), 
            'kategori_id' => $this->request->getPost('kategori_id') ?: null, 
        ]; 
    } 
} 