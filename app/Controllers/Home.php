<?php

namespace App\Controllers;

class Home extends BaseController
{
	private $petugasModel;
	private $session;

	public function __construct()
	{
		$this->petugasModel = new \App\Models\Petugas();
		$this->session = \Config\Services::session();
	}
	public function index()
	{
		return view('login');
	}

	// public function login_admin()
	// {
	// 	return view('login-admin');
	// }

	public function register()
	{
		return view('register');
	}

	public function auth()
	{
		$user = $this->request->getPost('username');
		$pass = $this->request->getPost('password');

		$cek = $this->petugasModel->where('username', $user)->first();
		if ($cek) {

			//cek pasword
			$cek_pw = password_verify($pass, $cek->password);
			if ($cek_pw) {

				//cek level login
				if ($cek->id_level == 1) {

					$session = ([
						'is_login' => true,
						'login_as' => "admin",
						'nama_petugas' => $cek->nama_petugas,
						'username' => $user,
						'id_petugas' => $cek->id_petugas
					]);
					$this->session->set($session);

					//alihkan ke halaman home
					return redirect()->to(base_url('/admin/home'));

					//jika level operator
				} elseif ($cek->id_level == 2) {

					$session = ([
						'is_login' => true,
						'login_as' => "operator",
						'nama_petugas' => $cek->nama_petugas,
						'username' => $user
					]);
					$this->session->set($session);

					//alihkan ke halaman home
					return redirect()->to(base_url('/operator/home'));
				} else {
					$session = ([
						'is_login' => true,
						'login_as' => "pegawai",
						'nama_petugas' => $cek->nama_petugas,
						'username' => $user
					]);
					$this->session->set($session);

					//alihkan ke halaman home
					return redirect()->to(base_url('/pegawai/home'));
				}
			} else {

				//membuat data alert gagal
				$sesi = ([
					'type' => 'danger',
					'message' => 'Maaf, username/password salah.',
				]);
				$this->session->setFlashdata($sesi);
				return redirect()->to(base_url());
			}
		} else {

			//membuat data alert gagal
			$sesi = ([
				'type' => 'danger',
				'message' => 'Maaf, username/password salah.',
			]);
			$this->session->setFlashdata($sesi);
			return redirect()->to(base_url());
		}
	}
	public function logout()
	{
		$this->session->destroy();
		return redirect()->to(base_url());
	}
}
