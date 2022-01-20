<?= $this->extend('admin/template'); ?>

<?= $this->section('konten'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Ruangan</h1>
    <a href="<?= base_url('/admin/ruangan/generate-ruangan') ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan</a>
</div>

<!-- info data produk -->
<div class="row">
    <div class="col-md-4">
        <?php if (isset($_GET['edit'])) {; ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Ruangan Sekolah</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/insert-edit-ruangan') ?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required value="<?= $detail->nama_ruang; ?>">
                            <input type="hidden" name="id_ruang" value="<?= $detail->id_ruang; ?>">
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode Ruangan</label>
                            <input type="text" name="kode" id="kode" value="<?= ($detail->kode_ruang); ?>" required pattern="[A-Z]{6}" title="Masukan 6 Karakter! contoh : XIIRPL" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ket">Keterangan</label>
                            <textarea class="form-control" name="ket" required id="ket" rows="4"><?= $detail->keterangan ?></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php } else {; ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Ruangan Sekolah</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/insert-ruangan') ?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="kode">Kode Ruangan</label>
                            <input type="text" name="kode" id="kode" required pattern="[A-Z]{6}" title="Masukan 6 Karakter! contoh : XIIRPL" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ket">Keterangan</label>
                            <textarea class="form-control" name="ket" required id="ket" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-sm btn-block">Tambahkan</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php }; ?>
    </div>
    <div class="col-md-8 col-sm-12">
        <?php if (isset($_SESSION['type'])) { ?>
            <div class="alert alert-<?= session()->type; ?> alert-dismissible fade show mb-2" role="alert">
                <?= session()->message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Ruangan Sekolah</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Aksi :</div>
                        <a class="dropdown-item" href="#">Generate Laporan</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name Ruangan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Name Ruangan</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach ($ruangan as $dr) {; ?>
                                <tr>
                                    <td><?= $no += 1; ?></td>
                                    <td><?= $dr->nama_ruang ?></td>
                                    <td><?= $dr->keterangan ?></td>
                                    <td>
                                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $dr->id_ruang) {; ?>
                                            <button type="button" class="text-warning btn btn-disable" disabled>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="text-danger btn" disabled>
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        <?php } else { ?>
                                            <a href="<?= base_url('/admin/ruangan/?edit=' . $dr->id_ruang) ?>" class="text-warning btn">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" data-toggle="modal" data-target="#hapus_<?= $dr->id_ruang ?>" class="text-danger btn">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <!-- Modal hapus-->
                                <div class="modal fade" id="hapus_<?= $dr->id_ruang ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h5><?= "Yakin ingin menghapus ruangan " . $dr->nama_ruang . " ?"; ?></h5>
                                                    <br>
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-dismiss="modal">Cancel</button>
                                                    <a href="<?= base_url('/admin/ruangan/' . $dr->id_ruang . '/delete') ?>" class="btn btn-sm btn-danger">Hapus</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }; #tutup foreach
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="btn-group">
    <button type="button" data-name="uid0" class="btn" data-toggle="btn-input" data-target="#puBtn0" value="uid0">
        <img src="http://placehold.it/50">
        <br>Randy</button>
    <input type="hidden" id="puBtn0" />
    <button type="button" data-name="uid1" class="btn" data-toggle="btn-input" data-target="#puBtn1" value="uid1">
        <img src="http://placehold.it/50">
        <br>Dick</button>
    <input type="hidden" id="puBtn1" />
    <button type="button" data-name="uid2" class="btn" data-toggle="btn-input" data-target="#puBtn2" value="uid2">
        <img src="http://placehold.it/50">
        <br>Jane</button>
    <input type="hidden" id="puBtn2" />
    <button type="button" data-name="uid3" class="btn" data-toggle="btn-input" data-target="#puBtn3" value="uid3">
        <img src="http://placehold.it/50">
        <br>Alice</button>
    <input type="hidden" id="puBtn3" />
    <button type="button" data-name="uid4" class="btn" data-toggle="btn-input" data-target="#puBtn4" value="uid4">
        <img src="http://placehold.it/50">
        <br>John</button>
    <input type="hidden" id="puBtn4" />
</div>
<div class="form-group">
    <label for="id_pegawai">Nama Pegawai</label>
    <select class="form-control" name="id_pegawai" id="id_pegawai" value="1" required>
        <?php foreach ($pegawai as $pe) {; ?>
            <option value="<?= $pe->id_pegawai; ?>"><?= $pe->nama_pegawai; ?></option>
        <?php }; ?>
    </select>
</div>
<div class="form-group">
    <label for="id_produk">Pilih Barang Pinjaman</label>
    <select class="form-control" name="id_produk" id="id_produk" value="1" required>
        <?php foreach ($produk as $i) {; ?>
            <option value="<?= $i->id_produk; ?>"><?= $i->nama; ?></option>
        <?php }; ?>
    </select>
</div>
<div class="form-group">
    <label for="jumlah">Jumlah Pinjaman</label>
    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" value="1" required>
</div>
<div class="form-group">
    <label for="jatuh_tempo">Jatuh Tempo</label>
    <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control" required>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-success">Tambahkan</button>
</div>
<?= $this->endsection('konten'); ?>