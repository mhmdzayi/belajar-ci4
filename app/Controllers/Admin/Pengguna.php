<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pengguna extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Manajemen Pengguna',
            'pengguna' => $this->userModel->getDaftarUser(),
        ];
        return view('admin/pengguna/index', $data);
    }

    public function toggleStatus($id)
    {
        $adminId = session()->get('user_id');

        if ($id == $adminId) {
            return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $newStatus = $user['aktif'] == 1 ? 0 : 1;
        $this->userModel->update($id, ['aktif' => $newStatus]);

        $statusText = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('sukses', "Akun pengguna {$user['username']} berhasil {$statusText}.");
    }

    public function ubahRole($id)
    {
        $adminId = session()->get('user_id');

        if ($id == $adminId) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $newRole = $this->request->getPost('role');
        $validRoles = ['admin', 'petugas', 'anggota'];

        if (!in_array($newRole, $validRoles)) {
            return redirect()->back()->with('error', 'Role tidak valid.');
        }

        $this->userModel->update($id, ['role' => $newRole]);

        return redirect()->back()->with('sukses', "Role pengguna {$user['username']} berhasil diubah menjadi {$newRole}.");
    }
}
