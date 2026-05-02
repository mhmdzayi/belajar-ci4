<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class='row justify-content-center'>
    <div class='col-lg-8'>
        <div class='card shadow-sm'>
            <div class='card-header bg-primary text-white d-flex align-items-center'>
                <img src='<?= avatar_url($nama) ?>' alt='<?= esc($nama) ?>' class='rounded-circle me-3' width='50' height='50'>
                <div>
                    <h3 class='mb-0'><i class='bi bi-person-circle'></i> Profil Mahasiswa</h3>
                    <small>Inisial: <span class='badge bg-light text-primary'><?= inisial_nama($nama) ?></span></small>
                </div>
            </div>
            <div class='card-body'>
                <div class='row mb-4'>
                    <div class='col-md-6'>
                        <h5>NPM</h5>
                        <p class='fw-semibold'><?= esc($npm) ?></p>
                    </div>
                    <div class='col-md-6'>
                        <h5>Nama Lengkap</h5>
                        <p class='fw-semibold'><?= esc($nama) ?></p>
                    </div>
                </div>

                <div class='row mb-4'>
                    <div class='col-md-6'>
                        <h5>Program Studi</h5>
                        <p class='fw-semibold'><?= esc($prodi) ?></p>
                    </div>
                    <div class='col-md-3'>
                        <h5>Angkatan</h5>
                        <p class='fw-semibold'><?= esc($angkatan) ?></p>
                    </div>
                    <div class='col-md-3'>
                        <h5>IPK</h5>
                        <p class='fw-semibold mb-0'><?= ipk_badge($ipk) ?></p>
                    </div>
                </div>

                <h5 class='mb-3'>Mata Kuliah Sedang Diambil</h5>
                <ul class='list-group list-group-flush'>
                    <?php foreach ($mata_kuliah as $matkul): ?>
                        <li class='list-group-item'><?= esc($matkul) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
