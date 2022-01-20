<?= $this->extend('admin/template'); ?>

<?= $this->section('konten'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Akun pelanggan</h1>
    <a href="<?= base_url('/admin/account/generate-pelanggan') ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan</a>
</div>

<!-- info data produk -->
<?php if (isset($_SESSION['type'])) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-<?= session()->type; ?> alert-dismissible fade show mb-2" role="alert">
                <?= session()->message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
<?php } ?>
<div class="row">
    <?php if (isset($_GET['edit'])) {; ?>
        <?php foreach ($edit as $e) : ?>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Akun pelanggan</h6>
                    </div>
                    <form action="<?= base_url('/admin/account/pelanggan/insert-edit') ?>" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_ktp">Nomor KTP</label>
                                        <input type="number" id="no_ktp" value="<?= $e->no_ktp; ?>" class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" id="nama" value="<?= $e->nama; ?>" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" name="alamat" id="alamat" rows="4"><?= $e->alamat; ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" value="<?= $e->email; ?>" required class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" value="password" required class="form-control" disabled>
                                        <small><a href="#" data-toggle="modal" data-target="#edit_pw_<?= $e->id_pelanggan; ?>"> Edit Password</a></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="telepon">Telepon</label>
                                        <input type="text" name="telepon" id="telepon" value="<?= $e->telepon; ?>" required class="form-control">
                                        <input type="hidden" name="id_pelanggan" value="<?= $e->id_pelanggan; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>


                <!-- Modal edit pw-->
                <div class="modal fade" id="edit_pw_<?= $e->id_pelanggan; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Password <?= $e->nama; ?> - pelanggan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('/admin/account/pelanggan/insert-edit-pw') ?>" method="post">
                                    <div class="form-group">
                                        <label for="pass">Password</label>
                                        <input type="password" name="pass" id="pass" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass2">Ulangi Password</label>
                                        <input type="password" name="pass2" id="pass2" class="form-control" required>
                                        <input type="hidden" name="id_pelanggan" value="<?= $e->id_pelanggan; ?>">
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal edit pw-->
            <div class="modal fade" id="edit_pw_<?= $e->id_pelanggan; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Password <?= $e->nama; ?> - Pelanggan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= base_url('/admin/account/pelanggan/insert-edit-pw') ?>" method="post">
                                <div class="form-group">
                                    <label for="pass">Password</label>
                                    <input type="password" name="pass" id="pass" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="pass2">Ulangi Password</label>
                                    <input type="password" name="pass2" id="pass2" class="form-control" required>
                                    <input type="hidden" name="id_pelanggan" value="<?= $e->id_pelanggan; ?>">
                                </div>
                                <div class="form-group text-right">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-sm btn-info">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    <?php } elseif (isset($_GET['detail'])) { ?>
        <?php foreach ($detail as $d) : ?>

            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Akun <?= $d->nama; ?></h6>
                    </div>
                    <form action="<?= base_url('/admin/account/pelanggan/insert-edit') ?>" method="post">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th>No KTP</th>
                                            <td>:</td>
                                            <td><?= $d->no_ktp; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama</th>
                                            <td>:</td>
                                            <td><?= $d->nama; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>:</td>
                                            <td><?= $d->telepon; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>:</td>
                                            <td><?= $d->email; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>:</td>
                                            <td><?= $d->alamat; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a name="" id="" class="btn btn-primary btn-sm" href="<?= current_url() ?>" role="button">
                                <i class="fa fa-backward" aria-hidden="true"></i>
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    <?php }  ?>

    <div class="col-md-12 col-sm-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Akun pelanggan</h6>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                    <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                    Tambah
                </button>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>KTP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach ($pelanggan as $p) {; ?>
                                <tr>
                                    <td><?= $no += 1; ?></td>
                                    <td><?= $p->no_ktp ?></td>
                                    <td><?= $p->nama ?></td>
                                    <td><?= $p->email ?></td>
                                    <td><?= $p->telepon ?></td>
                                    <td>
                                        <a href="<?= base_url('/admin/account/pelanggan/?edit=' . $p->id_pelanggan) ?>" class="text-warning btn">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $p->id_pelanggan or isset($_GET['detail']) and $_GET['detail'] == $p->id_pelanggan) {; ?>
                                            <button type="button" class="text-muted btn" disabled>
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="text-muted btn" disabled>
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                        <?php } else { ?>

                                            <button type="button" data-toggle="modal" data-target="#hapus_<?= $p->id_pelanggan ?>" class="text-danger btn">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                            <a href="<?= base_url('/admin/account/pelanggan/?detail=' . $p->id_pelanggan) ?>" class="text-default btn">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <!-- Modal hapus-->
                                <div class="modal fade" id="hapus_<?= $p->id_pelanggan ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h5><?= "Yakin ingin menghapus akun " . $p->nama . " ?"; ?></h5>
                                                    <br>
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-dismiss="modal">Cancel</button>
                                                    <a href="<?= base_url('/admin/account/pelanggan/' . $p->id_pelanggan . '/delete') ?>" class="btn btn-sm btn-danger">Hapus</a>
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


<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/admin/account/pelanggan/insert') ?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_ktp">Nomor KTP</label>
                                <input type="number" name="no_ktp" id="no_ktp" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="telepon">Telepon</label>
                                <input type="text" name="telepon" id="telepon" required class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" name="alamat" id="alamat" rows="4"></textarea>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
            </form>
        </div>
    </div>
</div>


<?= $this->endsection('konten'); ?>