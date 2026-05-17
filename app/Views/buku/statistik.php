<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='d-flex justify-content-between align-items-center mb-4'>
    <h2><i class='bi bi-graph-up'></i> Statistik Buku</h2>
    <a href='<?= base_url('buku') ?>' class='btn btn-secondary'>
        <i class='bi bi-arrow-left'></i> Kembali
    </a>
</div>

<!-- Ringkasan -->
<div class='row mb-4'>
    <div class='col-md-4'>
        <div class='card text-white bg-primary'>
            <div class='card-body'>
                <h5 class='card-title'>Total Buku</h5>
                <h3><?= $stats['total'] ?></h3>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card text-white bg-success'>
            <div class='card-body'>
                <h5 class='card-title'>Total Stok</h5>
                <h3><?= $stats['total_stok'] ?></h3>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card text-white bg-info'>
            <div class='card-body'>
                <h5 class='card-title'>Jumlah Kategori</h5>
                <h3><?= count($stats['per_kategori']) ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Per Kategori -->
<div class='card mb-4'>
    <div class='card-header bg-primary text-white'>
        <h5 class='mb-0'><i class='bi bi-list'></i> Distribusi per Kategori</h5>
    </div>
    <div class='table-responsive'>
        <table class='table table-hover mb-0'>
            <thead class='table-light'>
                <tr>
                    <th>Kategori</th>
                    <th width='140' class='text-center'>Jumlah Buku</th>
                    <th width='140' class='text-center'>Jumlah Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stats['per_kategori'] as $kat): ?>
                    <tr>
                        <td><?= esc($kat['nama'] ?? 'Tanpa Kategori') ?></td>
                        <td class='text-center'><span class='badge bg-info'><?= $kat['jumlah'] ?></span></td>
                        <td class='text-center'><span class='badge bg-success'><?= $kat['jumlah_stok'] ?? 0 ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Top 5 -->
<div class='card mb-4'>
    <div class='card-header bg-success text-white'>
        <h5 class='mb-0'><i class='bi bi-trophy'></i> Top 5 Buku (Stok Terbanyak)</h5>
    </div>
    <div class='table-responsive'>
        <table class='table table-hover mb-0'>
            <thead class='table-light'>
                <tr>
                    <th width='60'>No.</th>
                    <th>Judul</th>
                    <th width='160'>Kategori</th>
                    <th width='100' class='text-center'>Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($top5 as $i => $b): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($b['judul']) ?></td>
                        <td><span class='badge bg-info'><?= esc($b['nama_kategori'] ?? '-') ?></span></td>
                        <td class='text-center'><span class='badge bg-warning'><?= $b['stok'] ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Stok 0 -->
<div class='card'>
    <div class='card-header bg-danger text-white'>
        <h5 class='mb-0'><i class='bi bi-exclamation-triangle'></i> Buku dengan Stok 0</h5>
    </div>
    <?php if (empty($zeroStock)): ?>
        <div class='card-body text-center text-success'>
            <i class='bi bi-check-circle display-4'></i>
            <p class='mt-2'>Semua buku memiliki stok.</p>
        </div>
    <?php else: ?>
        <div class='table-responsive'>
            <table class='table table-hover mb-0'>
                <thead class='table-light'>
                    <tr>
                        <th width='60'>No.</th>
                        <th>Judul</th>
                        <th width='160'>Kategori</th>
                        <th width='120' class='text-center'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($zeroStock as $i => $b): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($b['judul']) ?></td>
                            <td><span class='badge bg-info'><?= esc($b['nama_kategori'] ?? '-') ?></span></td>
                            <td class='text-center'>
                                <a href='<?= base_url('buku/edit/'.$b['id']) ?>' class='btn btn-sm btn-warning'>
                                    <i class='bi bi-pencil'></i> Edit
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
