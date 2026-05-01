<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

    <h1 class="mb-4"><i class="bi bi-journals"></i> Daftar Buku</h1>

    <!-- Buku Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($daftar_buku as $buku): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($buku['judul']) ?></td>
                        <td><?= esc($buku['penulis']) ?></td>
                        <td><?= esc($buku['tahun']) ?></td>
                        <td><span class="badge bg-info"><?= esc($buku['kategori']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>
