<?php
namespace App\Controllers;

use App\Models\UserModel;

class Akun extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function gantiPassword()
    {
        $data = [
            'title' => 'Ganti Password',
        ];
        return view('akun/ganti_password', $data);
    }

    public function prosesGantiPassword()
    {
        $rules = [
            'password_lama' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password lama wajib diisi.'
                ]
            ],
            'password_baru' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required'   => 'Password baru wajib diisi.',
                    'min_length' => 'Password baru minimal 8 karakter.'
                ]
            ],
            'konfirmasi_password' => [
                'rules'  => 'required|matches[password_baru]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches'  => 'Konfirmasi password tidak cocok dengan password baru.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Pengguna tidak ditemukan.');
        }

        if (!password_verify((string) $this->request->getPost('password_lama'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password lama tidak sesuai.');
        }

        $newPasswordHash = password_hash((string) $this->request->getPost('password_baru'), PASSWORD_DEFAULT);

        $this->userModel->update($userId, ['password' => $newPasswordHash]);

        return redirect()->to('/')->with('sukses', 'Password berhasil diubah.');
    }
}
