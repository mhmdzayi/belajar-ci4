<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='d-flex justify-content-between align-items-center mb-4'>
    <div>
        <h2><i class='bi bi-bar-chart'></i> Statistik Buku</h2>
        <p class='text-muted mb-0'>Ringkasan data perpustakaan</p>
    </div>
    <a href='<?= base_url('buku') ?>' class='btn btn-secondary'>
        <i class='bi bi-arrow-left'></i> Kembali ke Daftar Buku
    </a>
</div>

<!-- Ringkasan Statistik -->
<div class='row mb-4'>
    <div class='col-md-4'>
        <div class='card bg-primary text-white shadow-sm h-100'>
            <div class='card-body text-center'>
                <h1 class='display-4'><?= esc($stats['total']) ?></h1>
                <p class='lead mb-0'>Total Buku Berbeda</p>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card bg-success text-white shadow-sm h-100'>
            <div class='card-body text-center'>
                <h1 class='display-4'><?= esc($stats['total_stok']) ?></h1>
                <p class='lead mb-0'>Total Stok Keseluruhan</p>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card bg-info text-white shadow-sm h-100'>
            <div class='card-body text-center'>
                <h1 class='display-4'><?= esc($stats['rata_stok']) ?></h1>
                <p class='lead mb-0'>Rata-rata Stok per Buku</p>
            </div>
        </div>
    </div>
</div>

<div class='row'>
    <!-- Distribusi Kategori -->
    <div class='col-md-12 mb-4'>
        <div class='card shadow-sm h-100'>
            <div class='card-header bg-white'>
                <h5 class='mb-0'><i class='bi bi-pie-chart'></i> Distribusi Buku per Kategori</h5>
            </div>
            <div class='card-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered align-middle'>
                        <thead class='table-light'>
                            <tr>
                                <th width='60' class='text-center'>No.</th>
                                <th>Kategori</th>
                                <th class='text-center'>Jumlah Judul Buku</th>
                                <th class='text-center'>Total Stok Tersedia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($statistik['per_kategori'])): ?>
                                <tr>
                                    <td colspan='4' class='text-center text-muted'>Belum ada data kategori</td>
                                </tr>
                            <?php else: ?>
                                <?php $no = 1; foreach ($statistik['per_kategori'] as $kat): ?>
                                    <tr>
                                        <td class='text-center'><?= $no++ ?></td>
                                        <td><strong><?= esc($kat['nama'] ?? 'Tanpa Kategori') ?></strong></td>
                                        <td class='text-center'><?= esc($kat['jumlah']) ?> Buku</td>
                                        <td class='text-center'>
                                            <span class='badge bg-<?= $kat['total_stok'] > 0 ? 'success' : 'secondary' ?>'>
                                                <?= esc($kat['total_stok'] ?? 0) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 5 Stok Terbanyak -->
    <div class='col-md-6 mb-4'>
        <div class='card shadow-sm h-100 border-success'>
            <div class='card-header bg-success text-white'>
                <h5 class='mb-0'><i class='bi bi-sort-up'></i> 5 Buku dengan Stok Terbanyak</h5>
            </div>
            <div class='card-body'>
                <ul class='list-group list-group-flush'>
                    <?php if (empty($statistik['top_stok'])): ?>
                        <li class='list-group-item text-center text-muted'>Belum ada data buku</li>
                    <?php else: ?>
                        <?php foreach ($statistik['top_stok'] as $buku): ?>
                            <li class='list-group-item d-flex justify-content-between align-items-center'>
                                <div>
                                    <strong><?= esc($buku['judul']) ?></strong><br>
                                    <small class='text-muted'><?= esc($buku['kode_buku']) ?></small>
                                </div>
                                <span class='badge bg-success rounded-pill'><?= esc($buku['stok']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Buku Perlu Restock (Stok 0) -->
    <div class='col-md-6 mb-4'>
        <div class='card shadow-sm h-100 border-danger'>
            <div class='card-header bg-danger text-white'>
                <h5 class='mb-0'><i class='bi bi-exclamation-triangle'></i> Buku Perlu Restock (Stok 0)</h5>
            </div>
            <div class='card-body'>
                <?php if (empty($statistik['stok_kosong'])): ?>
                    <div class='text-center py-4'>
                        <i class='bi bi-check-circle display-4 text-success mb-2'></i>
                        <p class='text-muted mb-0'>Semua buku masih memiliki stok.</p>
                    </div>
                <?php else: ?>
                    <ul class='list-group list-group-flush'>
                        <?php foreach ($statistik['stok_kosong'] as $buku): ?>
                            <li class='list-group-item d-flex justify-content-between align-items-center'>
                                <div>
                                    <strong><?= esc($buku['judul']) ?></strong><br>
                                    <small class='text-muted'><?= esc($buku['kode_buku']) ?></small>
                                </div>
                                <a href='<?= base_url('buku/edit/' . $buku['id']) ?>' class='btn btn-sm btn-outline-danger'>
                                    Update Stok
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
