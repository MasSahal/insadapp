<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    private $petugasModel;
    private $produkModel;
    private $pegawaiModel;
    private $penyewaanModel;
    private $detailSewaModel;
    private $jenisModel;
    private $cartModel;
    private $pelangganModel;
    private $validation;
    private $session;

    public function __construct()
    {
        $this->produkModel = new \App\Models\Produk();
        $this->pegawaiModel = new \App\Models\Pegawai();
        $this->petugasModel = new \App\Models\Petugas();
        $this->penyewaanModel = new \App\Models\Penyewaan();
        $this->detailSewaModel = new \App\Models\DetailPenyewaan();
        $this->jenisModel = new \App\Models\Jenis();
        $this->cartModel = new \App\Models\Cart();
        $this->pelangganModel = new \App\Models\Pelanggan();
        $this->session = \Config\Services::session();
        $this->validation =  \Config\Services::validation();

        if ($_SESSION['is_login'] = '') {
            return redirect()->to(base_url());
        }
    }
    public function index()
    {
        $petugas = $this->petugasModel->getDataWithLevel();
        $data = ([
            'produk'     => $this->produkModel->countAll(),
            'pegawai'       => $this->pegawaiModel->countAllResults(),
            'penyewaan'    => $this->penyewaanModel->countAll(),
            'petugas'       => $petugas,
        ]);
        return view('admin/home', $data);
    }

    //bagian roduk
    public function produk()
    {
        $id = $this->request->getGet('detail');

        //jika $id produk berhasil di tangkap
        if ($id) {
            //buat array detail
            $detail = $this->produkModel->getAll($id);

            //cek data, klo gada lempar balik ke halaman produk
            if ($detail == false) {
                return redirect()->to(base_url('/admin/produk'));
            }
        } else {
            $detail = false;
        }

        $getData = $this->produkModel->getAll();

        $data = ([
            'jenis' => $this->jenisModel->findAll(),
            'data_produk' => $getData,
            'detail' => $detail
        ]);
        // dd($data);   
        return view('admin/produk', $data);
    }

    public function insert_produk()
    {
        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $status = $this->request->getPost('status');
        $jenis = $this->request->getPost('jenis');
        $jumlah = $this->request->getPost('jumlah');
        $keterangan = $this->request->getPost('ket');
        $id_petugas = $_SESSION['id_petugas'];
        $tanggal = date('Y-m-d');

        $gambar = $this->request->getFile('foto');

        // $validated = $this->validate([
        //     'foto' => 'uploaded[foto]|mime_in[file,image/jpg,image/jpeg,image/png]' . '|max_size[foto,2048]'
        // ]);

        // EKSTENSI DIPERBOLEHKAN
        $allowed_image = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
        if (in_array($gambar->getExtension(), $allowed_image)) {

            //PERIKSA BESAR FILE
            $allowed_size = 2097152;
            if ($gambar->getSize() <= $allowed_size) {

                $nama_gambar = slug($nama) . "-" . $gambar->getRandomName();
                $gambar->move('./public/img/produk', $nama_gambar);

                //periksa apakah file berhasil pindah
                if (!$gambar->hasMoved()) {
                    $sesi = ([
                        'type' => 'danger',
                        'message' => 'Maaf, terjadi kesalahan saat megupload gambar!',
                    ]);
                    $this->session->setFlashdata($sesi);
                    return redirect()->to(base_url('/admin/produk'));
                }

                $data = $this->produkModel->orderBy('id_produk', 'desc')->first();
                if ($data) {
                    $kode_produk = "PD-" . sprintf("%06s", $data->id_produk + 1);
                } else {
                    $kode_produk = "PD-" . sprintf("%06s", 000000 + 1);
                }

                $data = ([
                    'nama' => $nama,
                    'harga' => $harga,
                    'status' => $status,
                    'keterangan' => $keterangan,
                    'jumlah' => $jumlah,
                    'jenis' => $jenis,
                    'tanggal_register' => $tanggal,
                    'kode_produk' => $kode_produk,
                    'gambar' => $nama_gambar,
                    'id_petugas' => $id_petugas
                ]);

                $add = $this->produkModel->insert($data);
                if ($add) {

                    //membuat data alert berhasil
                    $sesi = ([
                        'type' => 'success',
                        'message' => 'Selamat, data produk berhasil ditambahkan',
                    ]);
                    $this->session->setFlashdata($sesi);
                    return redirect()->to(base_url('/admin/produk'));
                } else {

                    //membuat data alert gagal
                    $sesi = ([
                        'type' => 'danger',
                        'message' => 'Maaf, data produk gagal ditambahkan',
                    ]);
                    $this->session->setFlashdata($sesi);
                    return redirect()->to(base_url('/admin/produk'));
                }
                #
            } else {
                //membuat data alert gagal
                $sesi = ([
                    'type' => 'danger',
                    'message' => 'Maaf, pastikan format gambar sesuai! - PNG, JPG, JPEG',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/produk'));
            }
            #
        } else {
            //membuat data alert gagal
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, Gambar Terlalu besar! - Max 2mb',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/produk'));
        }
    }

    public function insert_edit_produk()
    {
        $id_produk = $this->request->getPost('id_produk');

        $nama = $this->request->getPost('nama');
        $harga = $this->request->getPost('harga');
        $status = $this->request->getPost('status');
        $jumlah = $this->request->getPost('jumlah');
        $jenis = $this->request->getPost('jenis');
        $keterangan = $this->request->getPost('ket');
        $id_petugas = $_SESSION['id_petugas'];

        $data = ([
            'nama' => $nama,
            'harga' => $harga,
            'status' => $status,
            'keterangan' => $keterangan,
            'jumlah' => $jumlah,
            'jenis' => $jenis,
            'id_petugas' => $id_petugas
        ]);

        // dd($data);
        // die();
        // insert data
        $up = $this->produkModel->update($id_produk, $data);
        if ($up) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, data produk berhasil diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/produk'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, data produk gagal diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/produk'));
        }
    }

    public function add_stock_produk()
    {
        $id_produk = $this->request->getPost('id_produk');

        $jumlah = $this->request->getPost('jumlah');
        $produk = $this->produkModel->where('id_produk', $id_produk)->first();
        if ($id_produk) {

            $data = ([
                'jumlah' => $produk->jumlah + $jumlah,
            ]);

            $up = $this->produkModel->update($id_produk, $data);
            if ($up) {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'success',
                    'message' => 'Selamat, Stok produk berhasil diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
            } else {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'danger',
                    'message' => 'Maaf, Stok produk gagal diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
            }
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, data Produk tidak temukan diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
        }
        return redirect()->to(base_url('/admin/produk'));
    }

    public function edit_image_produk()
    {
        $nama = $this->request->getPost('nama');
        $foto_lama = $this->request->getPost('gambar');
        $id_produk = $this->request->getPost('id_produk');

        $gambar = $this->request->getFile('foto');


        // EKSTENSI DIPERBOLEHKAN
        $allowed_image = ['jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG'];
        if (in_array($gambar->getExtension(), $allowed_image)) {

            //PERIKSA BESAR FILE
            $allowed_size = 2097152;
            if ($gambar->getSize() <= $allowed_size) {

                $gambar_lama = (ROOTPATH . './public/img/produk/' . $foto_lama);

                if (file_exists($gambar_lama)) {
                    unlink($gambar_lama);
                }

                $nama_gambar = slug($nama) . "-" . $gambar->getRandomName();
                $gambar->move('./public/img/produk', $nama_gambar);

                if (!$gambar->hasMoved()) {
                    $sesi = ([
                        'type' => 'danger',
                        'message' => 'Maaf, terjadi kesalahan saat megupload gambar!',
                    ]);
                    $this->session->setFlashdata($sesi);
                    return redirect()->to(base_url('/admin/produk?detail=' . $id_produk));
                }

                $data = ([
                    'gambar' => $nama_gambar,
                ]);

                $up = $this->produkModel->update($id_produk, $data);
                if ($up) {

                    //membuat data alert berhasil
                    $sesi = ([
                        'type' => 'success',
                        'message' => 'Selamat, Gambar produk berhasil diperbarui!',
                    ]);
                    $this->session->setFlashdata($sesi);
                    return redirect()->to(base_url('/admin/produk?detail=' . $id_produk));
                } else {

                    //membuat data alert gagal
                    $sesi = ([
                        'type' => 'danger',
                        'message' => 'Maaf, Gambar produk gagal diperbarui!',
                    ]);
                    $this->session->setFlashdata($sesi);
                    return redirect()->to(base_url('/admin/produk?detail=' . $id_produk));
                }
            } else {
                //membuat data alert gagal
                $sesi = ([
                    'type' => 'danger',
                    'message' => 'Maaf, pastikan format gambar sesuai! - PNG, JPG, JPEG',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/produk?detail=' . $id_produk));
            }
            #
        } else {
            //membuat data alert gagal
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, Gambar Terlalu besar! - Max 2mb',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/produk?detail=' . $id_produk));
        }
    }

    public function delete_produk($id)
    {
        //ambil data produk
        $img = $this->produkModel->where('id_produk', $id)->first();
        $produk = $img->nama;
        //hapus gambar jika masih ada di folder
        if (file_exists(ROOTPATH . '/public/img/produk/' . $img->gambar)) {
            unlink(ROOTPATH . '/public/img/produk/' . $img->gambar);
        }

        $delete = $this->produkModel->where('id_produk', $id)->delete();
        if ($delete) {
            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => "Selamat, data produk $produk berhasil dihapus!",
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/produk'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => "Maaf, data produk $produk gagal dihapus!",
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/produk'));
        }
    }


    //bagian pelanggan
    public function pelanggan()
    {
        $id = $this->request->getGet('edit');

        //jika $id jenis berhasil di tangkap
        if ($id) {
            //buat array detail
            $edit = $this->pelangganModel->getAll($id);

            //cek data
            if ($edit == false) {
                $edit = false;
            }
        } else {
            $edit = false;
        }

        $id_det = $this->request->getGet('detail');

        //jika $id jenis berhasil di tangkap
        if ($id_det) {
            //buat array detail
            $detail = $this->pelangganModel->getAll($id_det);

            //cek data
            if ($detail == false) {
                $detail = false;
            }
        } else {
            $detail = false;
        }
        $data = ([
            'pelanggan' => $this->pelangganModel->findAll(),
            'edit' => $edit,
            'detail' => $detail
        ]);
        return view('admin/pelanggan', $data);
    }

    public function insert_pelanggan()
    {
        $nama = $this->request->getPost('nama');
        $no_ktp = $this->request->getPost('no_ktp');
        $telepon = $this->request->getPost('telepon');
        $email = $this->request->getPost('email');
        $alamat = $this->request->getPost('alamat');


        $data = ([
            'nama' => $nama,
            'no_ktp' => $no_ktp,
            'telepon' => $telepon,
            'email' => $email,
            'alamat' => $alamat,
            'password' => $telepon
        ]);

        // dd($data);
        $add = $this->pelangganModel->insert($data);
        if ($add) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => "Selamat, Pelanggan $nama berhasil ditambahkan!",
            ]);
            $this->session->setFlashdata($sesi);
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => "Maaf, Pelanggan $nama gagal ditambahkan!",
            ]);
            $this->session->setFlashdata($sesi);
        }
        return redirect()->to(base_url('/admin/account/pelanggan'));
    }
    public function insert_edit_pelanggan()
    {
        $id = $this->request->getPost('id_pelanggan');
        $nama = $this->request->getPost('nama');
        $telepon = $this->request->getPost('telepon');
        $email = $this->request->getPost('email');
        $alamat = $this->request->getPost('alamat');


        $data = ([
            'nama' => $nama,
            'telepon' => $telepon,
            'email' => $email,
            'alamat' => $alamat,
        ]);

        $upd = $this->pelangganModel->update($id, $data);
        if ($upd) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => "Selamat, Pelanggan $nama berhasil diperbarui!",
            ]);
            $this->session->setFlashdata($sesi);
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => "Maaf, Pelanggan $nama gagal diperbarui!",
            ]);
            $this->session->setFlashdata($sesi);
        }
        return redirect()->to(base_url('/admin/account/pelanggan'));
    }

    public function insert_edit_pw_pelanggan()
    {
        $id_pelanggan = $this->request->getPost('id_pelanggan');
        $pass = $this->request->getPost('pass');
        $pass2 = $this->request->getPost('pass2');

        //cek kesamaan password
        if ($pass == $pass2) {
            $data['password'] = password_hash($pass, PASSWORD_BCRYPT);

            $up_pw = $this->pelangganModel->update($id_pelanggan, $data);
            if ($up_pw) {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'success',
                    'message' => 'Selamat, password berhasil diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
            } else {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'danger',
                    'message' => 'Maaf, password gagal diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
            }
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, password tidak sama!',
            ]);
            $this->session->setFlashdata($sesi);
        }
        #
        return redirect()->to(base_url('/admin/account/pelanggan?edit=' . $id_pelanggan));
    }

    public function delete_pelanggan($id)
    {
        $delete = $this->pelangganModel->where('id_pelanggan', $id)->delete();
        if ($delete) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, Akun Pelanggan berhasil dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, Akun Pelanggan gagal dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
        }
        #
        return redirect()->to(base_url('/admin/account/pelanggan'));
    }

    public function get_pelanggan()
    {
        echo json_encode($this->pelangganModel->findAll());
    }


    //bagian akun admin
    public function administrator()
    {
        $id = $this->request->getGet('edit');

        //jika $id admin berhasil di tangkap
        if ($id) {
            //buat array edit
            $edit = $this->petugasModel->getAdmin($id);

            //cek data
            if ($edit == false) {
                $edit = false;
            }
        } else {
            $edit = false;
        }
        $data = ([
            'admin' => $this->petugasModel->getAdmin(),
            'edit' => $edit
        ]);
        return view('admin/administrator', $data);
    }

    public function insert_administrator()
    {
        $nama = $this->request->getPost('nama');
        $user = $this->request->getPost('user');
        $pass = $this->request->getPost('pass');

        $data = ([
            'nama_petugas' => $nama,
            'username' => $user,
            'password' => password_hash($pass, PASSWORD_BCRYPT),
            'id_level' => 1,
        ]);

        // dd($data);
        $add = $this->petugasModel->insert($data);
        if ($add) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, akun admin ' . $nama . ' berhasil ditambahkan!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/administrator'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, akun admin ' . $nama . '  gagal ditambahkan!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/administrator'));
        }
    }

    public function insert_edit_administrator()
    {
        $nama = $this->request->getPost('nama');
        $user = $this->request->getPost('user');
        $id_petugas = $this->request->getPost('id_petugas');

        $data = ([
            'nama_petugas' => $nama,
            'username' => $user
        ]);

        // dd($data);
        $upp = $this->petugasModel->update($id_petugas, $data);
        if ($upp) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, akun ' . $nama . ' berhasil diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/administrator'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, akun ' . $nama . ' gagal diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/administrator'));
        }
    }

    public function insert_edit_pw_administrator()
    {
        $id_petugas = $this->request->getPost('id_petugas');
        $pass = $this->request->getPost('pass');
        $pass2 = $this->request->getPost('pass2');

        //cek kesamaan password
        if ($pass == $pass2) {
            $data['password'] = password_hash($pass, PASSWORD_BCRYPT);

            $up_pw = $this->petugasModel->update($id_petugas, $data);
            if ($up_pw) {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'success',
                    'message' => 'Selamat, password berhasil diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/account/administrator?edit=' . $id_petugas));
            } else {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'danger',
                    'message' => 'Maaf, password gagal diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/account/administrator?edit=' . $id_petugas));
            }
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, password tidak sama!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/administrator?edit=' . $id_petugas));
        }
    }

    public function delete_administrator($id)
    {
        $delete = $this->petugasModel->where('id_petugas', $id)->delete();
        if ($delete) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, Akun admin berhasil dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/administrator'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, Akun admin gagal dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/administrator'));
        }
    }

    public function generate_administrator()
    {

        $administrator = $this->petugasModel->getAdmin();

        $data = [
            'administrator' => $administrator
        ];
        return view('admin/data/print_administrator', $data);
    }


    //bagian akun operator
    public function operator()
    {
        $id = $this->request->getGet('edit');

        //jika $id operator berhasil di tangkap
        if ($id) {
            //buat array edit
            $edit = $this->petugasModel->getOperator($id);

            //cek data
            if ($edit == false) {
                $edit = false;
            }
        } else {
            $edit = false;
        }
        $data = ([
            'operator' => $this->petugasModel->getOperator(),
            'edit' => $edit
        ]);
        return view('admin/operator', $data);
    }

    public function insert_operator()
    {
        $nama = $this->request->getPost('nama');
        $user = $this->request->getPost('user');
        $pass = $this->request->getPost('pass');

        $data = ([
            'nama_petugas' => $nama,
            'username' => $user,
            'password' => password_hash($pass, PASSWORD_BCRYPT),
            'id_level' => 2
        ]);

        // dd($data);
        $add = $this->petugasModel->insert($data);
        if ($add) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, akun operator ' . $nama . ' berhasil ditambahkan!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/operator'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, akun operator ' . $nama . '  gagal ditambahkan!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/operator'));
        }
    }

    public function insert_edit_operator()
    {
        $nama = $this->request->getPost('nama');
        $user = $this->request->getPost('user');
        $pass = $this->request->getPost('pass');
        $id_petugas = $this->request->getPost('id_petugas');

        $data = ([
            'nama_petugas' => $nama,
            'username' => $user,
            'password' => $pass
        ]);

        // dd($data);
        $upp = $this->petugasModel->update($id_petugas, $data);
        if ($upp) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, akun operator ' . $nama . ' berhasil diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/operator'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, akun operator ' . $nama . ' gagal diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/operator'));
        }
    }

    public function insert_edit_pw_operator()
    {
        $id_petugas = $this->request->getPost('id_petugas');
        $pass = $this->request->getPost('pass');
        $pass2 = $this->request->getPost('pass2');

        //cek kesamaan password
        if ($pass == $pass2) {
            $data['password'] = password_hash($pass, PASSWORD_BCRYPT);

            $up_pw = $this->petugasModel->update($id_petugas, $data);
            if ($up_pw) {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'success',
                    'message' => 'Selamat, password berhasil diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/account/operator?edit=' . $id_petugas));
            } else {

                //membuat data alert gagal
                $sesi = ([
                    'type' => 'danger',
                    'message' => 'Maaf, password gagal diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/account/operator?edit=' . $id_petugas));
            }
        } else {
            //membuat data alert gagal
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, password tidak sama!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/operator?edit=' . $id_petugas));
        }
    }

    public function delete_operator($id)
    {
        $delete = $this->petugasModel->where('id_petugas', $id)->delete();
        if ($delete) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, Akun operator berhasil dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/operator'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, Akun operator gagal dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/operator'));
        }
    }

    public function generate_operator()
    {

        $operator = $this->petugasModel->getOperator();

        $data = [
            'operator' => $operator
        ];
        return view('admin/data/print_operator', $data);
    }

    //bagian penyewaan
    public function penyewaan()
    {
        $id = $this->request->getGet('detail');

        //jika $id penyewaan berhasil di tangkap
        if ($id) {
            //buat array detail
            $detail = $this->penyewaanModel->getPenyewaan($id);
            $detail2 = $this->detailSewaModel->where('id_sewa', $id)->find();

            //cek data
            if ($detail == false && $detail2 == false) {

                //klo gak ada data yg di pilih maka di lempar ke halaman penyewaan
                return redirect()->to(base_url('/admin/penyewaan'));
            }
        } else {
            $detail = false;
            $detail2 = false;
        }

        $data = ([
            'produk' => $this->produkModel->findAll(),
            'pegawai' => $this->pegawaiModel->findAll(),
            'penyewaan' => $this->penyewaanModel->getPenyewaan(),
            'detail' => $detail,
            'detail2' => $detail2
        ]);
        return view('admin/penyewaan', $data);
    }


    public function form_penyewaan()
    {
        $detail = $this->penyewaanModel->getPenyewaan();
        $data = ([
            'produk' => $this->produkModel->where('jenis', 'sewa')->findAll(),
            'pegawai' => $this->pegawaiModel->findAll(),
            'cart' => $this->cartModel->findAll(),
        ]);
        return view('admin/data/form-penyewaan', $data);
    }

    public function add_cart()
    {
        $id_produk = $this->request->getPost('id_produk');
        $qty = $this->request->getPost('qty');
        $nama = $this->request->getPost('nama');
        $jenis = $this->request->getPost('jenis');
        $harga = $this->request->getPost('harga');
        // dd($this->request->getPost());
        //cek data apakah sudah ada
        $cek = $this->cartModel->where('id_produk', $id_produk)->first();
        if ($cek) {
            $total = $qty + $cek->qty;
            $data = [
                'id_cart' => $cek->id_cart,
                'qty' => $total,
            ];

            $upd = $this->cartModel->save($data);
            // dd($total);
            if ($upd) {
                $sesi = ([
                    'type' => 'success',
                    'message' => "Produk $nama, berhasil diperbarui dalam keranjang!",
                ]);
                $this->session->setFlashdata($sesi);
            } else {
                $sesi = ([
                    'type' => 'danger',
                    'message' => "Produk $nama, gagal diperbarui dalam keranjang!",
                ]);
                $this->session->setFlashdata($sesi);
            }

            #
        } else {
            $data = [
                'id_produk' => $id_produk,
                'nama_produk' => $nama,
                'qty' => $qty,
                'jenis' => $jenis,
                'harga' => $harga,
            ];
            $add = $this->cartModel->insert($data);
            if ($add) {
                $sesi = ([
                    'type' => 'success',
                    'message' => "Produk $nama, berhasil ditambahkan!",
                ]);
                $this->session->setFlashdata($sesi);
            } else {
                $sesi = ([
                    'type' => 'danger',
                    'message' => "Produk $nama, gagal ditambahkan!",
                ]);
                $this->session->setFlashdata($sesi);
            }
        }

        $produk = $this->produkModel->where('id_produk', $id_produk)->first();

        //update barang di table produk
        $stok_baru = $produk->jumlah - $qty;
        $updProduk = $this->produkModel->update($id_produk, ['jumlah' => $stok_baru]);
        if (!$updProduk) {
            $sesi = ([
                'type' => 'danger',
                'message' => "Terjadi kesalahan saat memperbarui data stok produk $nama",
            ]);
            $this->session->setFlashdata($sesi);
        }
        return redirect()->to(previous_url());
    }

    public function del_cart($id_produk)
    {
        // ambil data prosuk
        $produk = $this->produkModel->where('id_produk', $id_produk)->first();

        // ambil data keranjnag
        $cart = $this->cartModel->where("id_produk", $id_produk)->first();

        //kembalikasn stok prosuk
        $stok_baru = $produk->jumlah + $cart->qty;

        $nama = $produk->nama;

        $del = $this->cartModel->delete($cart->id_cart);
        if ($del) {

            //update barang di table produk
            $updProduk = $this->produkModel->update($id_produk, ['jumlah' => $stok_baru]);
            if (!$updProduk) {
                $sesi = ([
                    'type' => 'danger',
                    'message' => "Terjadi kesalahan saat memperbarui data stok produk $nama",
                ]);
                $this->session->setFlashdata($sesi);
            }

            $sesi = ([
                'type' => 'success',
                'message' => "Berhasil menghapus produk $nama dikeranjang!",
            ]);
            $this->session->setFlashdata($sesi);
            #
        } else {
            $sesi = ([
                'type' => 'danger',
                'message' => "Terjadi kesalahan saat menghapus produk $nama dikeranjang!",
            ]);
            $this->session->setFlashdata($sesi);
        }
        return redirect()->to(previous_url());
    }

    public function get_cart()
    {
        $jenis = $this->request->getPost('jenis');
        if (isset($jenis)) {
            $record = $this->cartModel->where('jenis', $jenis)->findAll();
        } else {
            $record = $this->cartModel->findAll();
        }
        echo json_encode($record);
    }
    public function insert_penyewaan()
    {
        // dd($this->request->getPost());
        // die();
        // var_dump(json_encode($this->request->getPost('id_produk')));
        // die();
        //id penyewaan di buat manual

        //input data pelanggan dulu
        $nama_pel = $this->request->getPost('nama');
        $no_ktp = $this->request->getPost('no_ktp');

        //lihat data apakah sudah terdaftar sebagai pelanggan
        $pelanggan = $this->pelangganModel->where('nama', $nama_pel)->where('no_ktp', $no_ktp)->first();
        if ($pelanggan) {
            #
            $data_pelanggan = $pelanggan;
        } else {
            #
            $pel = [
                'nama' => $nama_pel,
                'no_ktp' => $no_ktp,
                'passowrd' => password_hash($this->request->getPost('no_ktp'), PASSWORD_BCRYPT),
            ];
            $add_pelanggan = $this->pelangganModel->insert($pel);
            if (!$add_pelanggan) {
                $sesi = ([
                    'type' => 'danger',
                    'message' => "Terjadi kesalahan saat menambahkan pelanggan $nama!",
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/penyewaan'));
            }
            //ambil pelanggan yang terakhir di simpan
            $data_pelanggan = $this->pelangganModel->orderBy('id_pelanggan', 'desc')->first();
        }


        //buat kode sewa
        $data_sewa = $this->penyewaanModel->orderBy('id', 'desc')->first();
        if ($data_sewa) {
            $id_penyewaan = "SW-" . sprintf("%06s", $data_sewa->id + 1);
        } else {
            $id_penyewaan = "SW-" . sprintf("%06s", 000000 + 1);
        }

        //buat data detail penyewaan
        $id_produk = $this->request->getPost('id_produk');
        $nama_produk = $this->request->getPost('nama_produk');
        $harga = $this->request->getPost('harga');
        $qty = $this->request->getPost('qty');

        for ($i = 0; $i < count($id_produk); $i++) {
            $det_sewa = [
                'id_sewa' => $id_penyewaan,
                'id_produk' => $id_produk[$i],
                'nama_produk' => $nama_produk[$i],
                'harga' => $harga[$i],
                'qty' => $qty[$i],
            ];

            //ambil produk
            $p = $this->produkModel->where('id_produk', $id_produk[$i])->first();

            //perbarui stok produk
            $this->produkModel->update($id_produk[$i], ['jumlah' => $p->jumlah - $qty[$i]]);

            //tambahkan data detail sewa
            $this->detailSewaModel->insert($det_sewa);
        }



        //jatuh tempo dengan jam
        $jatuh_tempo = date("Y-m-d H:i:s", strtotime($this->request->getPost('jatuh_tempo') . " " . date("H:i:s")));
        $data_sewa = [
            'id_penyewaan' => $id_penyewaan,
            'id_pelanggan' => $data_pelanggan->id_pelanggan,
            'tanggal_penyewaan' => date("Y-m-d H:i:s"),
            'jatuh_tempo' => $jatuh_tempo,
            'status_penyewaan' => "disewa",
            'id_pegawai' => $_SESSION['id_petugas'],
            'id_produk' => json_encode($id_produk),
            'jumlah_tagihan' => $this->request->getPost('jumlah_tagihan')
        ];

        //insert data ke tabel penyewaan
        $sewa = $this->penyewaanModel->insert($data_sewa);
        if ($sewa) {

            //masukan detail nya

            // membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, penyewaan berhasil!',
            ]);
            $this->session->setFlashdata($sesi);
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, penyewaan tidak berhasil!',
            ]);
            $this->session->setFlashdata($sesi);
        }
        return redirect()->to(base_url('/admin/penyewaan'));
    }


    public function tambah_penyewaan()
    {
        dd($this->request->getPost());
        die();
        //id penyewaan di buat manual
        $id_penyewaan  = 20 . time();
        $id_pegawai     = $this->request->getPost('id_pegawai');
        $id_produk  = $this->request->getPost('id_produk');
        $jumlah         = $this->request->getPost('jumlah');
        $hari_sewa       = $this->request->getPost('jatuh_tempo');

        $jatuh_tempo = date("Y-m-d H:i:s", strtotime($hari_sewa . " " . date("H:i:s")));
        // die();

        // kurangi jmlah di produk
        $produk = $this->produkModel->where('id_produk', $id_produk)->first();

        if ($produk->jumlah != 0) {
            $hasil_kurangi = $produk->jumlah - $jumlah;


            //update jumlah data barang
            $this->produkModel->update($produk->id_produk, ['jumlah' => $hasil_kurangi]);

            // data buat masukan ke table detail penyewaan
            $detail_penyewaan = ([
                'id_penyewaan' => $id_penyewaan,
                'id_produk' => $id_produk,
                'jumlah_sewa' => $jumlah
            ]);

            //data buat masukan ke tabel penyewaan
            $data = ([
                'id_penyewaan'         => $id_penyewaan,
                'tanggal_penyewaan'    => date('Y-m-d H:i:s'),
                'jatuh_tempo'           => $jatuh_tempo,
                'status_penyewaan'     => 'disewa',
                'id_pegawai'            => $id_pegawai
            ]);

            $this->penyewaanModel->insert($data);
            $tambah_detail = $this->detailSewaModel->insert($detail_penyewaan);
            if ($tambah_detail) {

                //masukan detail nya

                // membuat data alert berhasil
                $sesi = ([
                    'type' => 'success',
                    'message' => 'Selamat, penyewaan berhasil!',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/penyewaan'));
            } else {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'danger',
                    'message' => 'Maaf, penyewaan tidak berhasil!',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/penyewaan'));
            }

            //
        } else {
            //membuat data alert gagal data kosong
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, Stok barang sedang tidak ada',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/penyewaan'));
        }
    }

    public function kembalikan_penyewaan()
    {

        $id_penyewaan = $this->request->getPost('id_penyewaan');
        $det_penyewaan = $this->detailSewaModel->where('id_sewa', $id_penyewaan)->first();

        //cari data produk
        $produk = $this->produkModel->where('id_produk', $det_penyewaan->id_produk)->first();

        $hasil = $det_penyewaan->qty + $produk->jumlah;

        // update data jumlah produk
        $this->produkModel->update($produk->id_produk, ['jumlah' => $hasil]);

        //ubah status pinjam jadi dikembalikan

        $kembalikan = ([
            'tanggal_kembali' => date('Y-m-d H:i:s'),
            'status_penyewaan' => 'dikembalikan'
        ]);
        // dd($kembalikan);
        $kembali = $this->penyewaanModel->kembalikanStok($id_penyewaan, $kembalikan);

        if ($kembali) {
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, penyewaan berhasil dikembalikan!',
            ]);
            $this->session->setFlashdata($sesi);
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, penyewaan tidak berhasil dikembalikan!',
            ]);
            $this->session->setFlashdata($sesi);
        }

        // redirect ke halaman penyewaan
        return redirect()->to(base_url('/admin/penyewaan'));
    }

    public function generate_penyewaan()
    {

        $penyewaan = $this->penyewaanModel->getpenyewaan();

        $data = [
            'penyewaan' => $penyewaan
        ];
        return view('admin/data/print_penyewaan', $data);
    }


    //bagian jenis
    public function jenis()
    {
        $id = $this->request->getGet('edit');

        //jika $id jenis berhasil di tangkap
        if ($id) {
            //buat array detail
            $detail = $this->jenisModel->where('id_jenis', $id)->first();

            //cek data
            if ($detail == false) {
                $detail = false;
            }
        } else {
            $detail = false;
        }
        $data = ([
            'jenis' => $this->jenisModel->orderBy('nama_jenis', 'ASC')->findAll(),
            'detail' => $detail
        ]);
        return view('admin/jenis', $data);
    }

    public function insert_jenis()
    {
        $nama = $this->request->getPost('nama');
        $ket = $this->request->getPost('ket');


        $data = ([
            'nama_jenis' => $nama,
            'keterangan' => $ket
        ]);

        // dd($data);
        $add = $this->jenisModel->insert($data);
        if ($add) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, data jenis berhasil ditambahkan!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/jenis'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, data jenis gagal ditambahkan!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/jenis'));
        }
    }

    public function insert_edit_jenis()
    {
        $nama = $this->request->getPost('nama');
        $ket = $this->request->getPost('ket');
        $id_jenis = $this->request->getPost('id_jenis');


        $data = ([
            'nama_jenis' => $nama,
            'keterangan' => $ket
        ]);

        // dd($data);
        $upp = $this->jenisModel->update($id_jenis, $data);
        if ($upp) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, data jenis berhasil diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/jenis'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, data jenis gagal diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/jenis'));
        }
    }

    public function delete_jenis($id_jenis)
    {
        $delete = $this->jenisModel->where('id_jenis', $id_jenis)->delete();
        if ($delete) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, data jenis berhasil dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/jenis'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, data jenis gagal dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/jenis'));
        }
    }

    public function generate_jenis()
    {

        $jenis = $this->jenisModel->findAll();

        $data = [
            'jenis' => $jenis
        ];
        return view('admin/data/print_jenis', $data);
    }



    //bagian akun pegawai
    public function pegawai()
    {
        $id = $this->request->getGet('edit');

        //jika $id pegawai berhasil di tangkap
        if ($id) {
            //buat array edit
            $edit = $this->pegawaiModel->where('id_pegawai', $id)->findAll();

            //cek data
            if ($edit == false) {
                $edit = false;
            }
        } else {
            $edit = false;
        }
        $data = ([
            'pegawai' => $this->pegawaiModel->findAll(),
            'edit' => $edit
        ]);
        return view('admin/pegawai', $data);
    }

    public function insert_pegawai()
    {
        $nip = $this->request->getPost('nip');
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $pass = $this->request->getPost('pass');

        $data = ([
            'nama_pegawai' => $nama,
            'nip' => $nip,
            'password' => password_hash($pass, PASSWORD_BCRYPT),
            'alamat' => $alamat
        ]);

        // dd($data);
        $add = $this->pegawaiModel->insert($data);
        if ($add) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, akun pegawai ' . $nama . ' berhasil ditambahkan!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/pegawai'));
        } else {

            //membuat data alert gagal
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, akun pegawai ' . $nama . '  gagal ditambahkan!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/pegawai'));
        }
    }

    public function insert_edit_pegawai()
    {
        $nip = $this->request->getPost('nip');
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $pass = $this->request->getPost('pass');
        $id_pegawai = $this->request->getPost('id_pegawai');

        $data = ([
            'nama_pegawai' => $nama,
            'nip' => $nip,
            'password' => password_hash($pass, PASSWORD_BCRYPT),
            'alamat' => $alamat
        ]);

        // dd($data);
        $upp = $this->pegawaiModel->update($id_pegawai, $data);
        if ($upp) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, akun pegawai ' . $nama . ' berhasil diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/pegawai'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, akun pegawai ' . $nama . ' gagal diperbarui!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/pegawai'));
        }
    }

    public function insert_edit_pw_pegawai()
    {
        $id_pegawai = $this->request->getPost('id_pegawai');
        $pass = $this->request->getPost('pass');
        $pass2 = $this->request->getPost('pass2');

        //cek kesamaan password
        if ($pass == $pass2) {
            $data['password'] = password_hash($pass, PASSWORD_BCRYPT);

            $up_pw = $this->pegawaiModel->update($id_pegawai, $data);
            if ($up_pw) {

                //membuat data alert berhasil
                $sesi = ([
                    'type' => 'success',
                    'message' => 'Selamat, password berhasil diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/account/pegawai?edit=' . $id_pegawai));
            } else {

                //membuat data alert gagal
                $sesi = ([
                    'type' => 'danger',
                    'message' => 'Maaf, password gagal diperbarui!',
                ]);
                $this->session->setFlashdata($sesi);
                return redirect()->to(base_url('/admin/account/pegawai?edit=' . $id_pegawai));
            }
        } else {
            //membuat data alert gagal
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, password tidak sama!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/pegawai?edit=' . $id_petugas));
        }
    }

    public function delete_pegawai($id)
    {
        $delete = $this->petugasModel->where('id_petugas', $id)->delete();
        if ($delete) {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'success',
                'message' => 'Selamat, Akun pegawai berhasil dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/pegawai'));
        } else {

            //membuat data alert berhasil
            $sesi = ([
                'type' => 'danger',
                'message' => 'Maaf, Akun pegawai gagal dihapus!',
            ]);
            $this->session->setFlashdata($sesi);
            return redirect()->to(base_url('/admin/account/pegawai'));
        }
    }

    public function generate_pegawai()
    {

        $pegawai = $this->pegawaiModel->findAll();

        $data = [
            'pegawai' => $pegawai
        ];
        return view('admin/data/print_pegawai', $data);
    }
}
