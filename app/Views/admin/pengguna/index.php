<?= $this->extend('layout/main'); ?>

<?= $this->section('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people"></i> Manajemen Pengguna</h2>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th width="50" class="text-center">No.</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th width="100" class="text-center">Status</th>
                        <th width="200">Role</th>
                        <th width="150" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengguna as $i => $u): ?>
                        <tr>
                            <td class="text-center"><?= $i + 1 ?></td>
                            <td><?= esc($u['username']) ?></td>
                            <td><?= esc($u['nama_lengkap']) ?></td>
                            <td><?= esc($u['email']) ?></td>
                            <td class="text-center">
                                <?php if ($u['aktif']): ?>
                                    <span class="badge bg-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($u['id'] == session()->get('user_id')): ?>
                                    <span class="badge bg-primary w-100"><?= esc(ucfirst($u['role'])) ?></span>
                                    <small class="d-block text-muted text-center mt-1">Anda</small>
                                <?php else: ?>
                                    <form action="<?= base_url('admin/pengguna/ubah-role/' . $u['id']) ?>" method="post" class="d-flex align-items-center">
                                        <?= csrf_field() ?>
                                        <select name="role" class="form-select form-select-sm me-1" required>
                                            <option value="anggota" <?= $u['role'] == 'anggota' ? 'selected' : '' ?>>Anggota</option>
                                            <option value="petugas" <?= $u['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                            <option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary" title="Ubah Role"><i class="bi bi-check2"></i> Ubah</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($u['id'] == session()->get('user_id')): ?>
                                    <button class="btn btn-sm btn-secondary w-100" disabled title="Tidak dapat menonaktifkan akun sendiri">
                                        <i class="bi bi-shield-lock"></i> Terkunci
                                    </button>
                                <?php else: ?>
                                    <form action="<?= base_url('admin/pengguna/toggle-status/' . $u['id']) ?>" method="post" class="d-inline w-100">
                                        <?= csrf_field() ?>
                                        <?php if ($u['aktif']): ?>
                                            <button type="submit" class="btn btn-sm btn-danger w-100" title="Nonaktifkan" onclick="return confirm('Yakin ingin menonaktifkan pengguna ini?')">
                                                <i class="bi bi-x-circle"></i> Nonaktifkan
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn btn-sm btn-success w-100" title="Aktifkan" onclick="return confirm('Yakin ingin mengaktifkan pengguna ini?')">
                                                <i class="bi bi-check-circle"></i> Aktifkan
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
