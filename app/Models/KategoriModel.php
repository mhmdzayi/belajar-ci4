<?php 
  
namespace App\Models; 
  
use CodeIgniter\Model; 
  
class KategoriModel extends Model 
{ 
    protected $table            = 'kategori'; 
    protected $primaryKey       = 'id'; 
    protected $useAutoIncrement = true; 
    protected $returnType       = 'array'; 
    protected $useSoftDeletes   = false; 
    protected $useTimestamps    = true; 
    protected $allowedFields    = ['nama', 'deskripsi']; 
  
    /** 
     * Ambil semua kategori sebagai dropdown options 
     * Return: ['id' => 'nama'] untuk form select 
     */ 
    public function getDropdown(): array 
    { 
        $kategori = $this->orderBy('nama')->findAll(); 
        $result = ['' => '-- Pilih Kategori --']; 
        foreach ($kategori as $k) { 
            $result[$k['id']] = $k['nama']; 
        } 
        return $result; 
    } 

    /**
     * Ambil semua kategori beserta jumlah buku pada masing-masing kategori
     * Return: array of ['id','nama','deskripsi','jumlah']
     */
    public function getAllWithCounts(): array
    {
        $db = \Config\Database::connect();
        return $db->table('kategori')
            ->select('kategori.id, kategori.nama, kategori.deskripsi, COUNT(buku.id) AS jumlah')
            ->join('buku', 'buku.kategori_id = kategori.id', 'left')
            ->groupBy('kategori.id')
            ->orderBy('kategori.nama', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Cek apakah nama kategori sudah ada (opsional mengecualikan id tertentu)
     */
    public function isNameTaken(string $nama, int $excludeId = 0): bool
    {
        $qb = $this->where('nama', $nama);
        if ($excludeId > 0) {
            $qb->where('id !=', $excludeId);
        }
        return $qb->countAllResults() > 0;
    }
} 