<?= $this->extend('admin/template'); ?>

<?= $this->section('konten'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Akun Operator</h1>
    <a href="<?= base_url('/admin/account/generate-operator') ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan</a>
</div>

<!-- info data produk -->
<div class="row">
    <div class="col-md-4">
        <?php if (isset($_GET['edit'])) {; ?>
            <?php foreach ($edit as $e) :; ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Akun operator</h6>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('/admin/account/operator/insert-edit') ?>" method="post">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required value="<?= $e->nama_petugas; ?>">
                                <input type="hidden" name="id_petugas" value="<?= $e->id_petugas; ?>">
                            </div>
                            <div class="form-group">
                                <label for="user">Username</label>
                                <input type="text" name="user" id="user" value="<?= $e->username; ?>" pattern="[a-z]{3,15}" title="Gunakan lowercase" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="pass">Password</label>
                                <input type="text" name="pass" id="pass" value="<?= $e->password; ?>" required class="form-control" readonly>
                                <small><a href="#" id="edit_pw" data-toggle="modal" data-target="#edit_pw_<?= $e->id_petugas; ?>">Edit Password</a></small>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm btn-block">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>


                <!-- Modal edit pw-->
                <div class="modal fade" id="edit_pw_<?= $e->id_petugas; ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Password <?= $e->nama_petugas; ?> - Operator</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= base_url('/admin/account/operator/insert-edit-pw') ?>" method="post">
                                    <div class="form-group">
                                        <label for="pass">Password</label>
                                        <input type="password" name="pass" id="pass" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass2">Ulangi Password</label>
                                        <input type="password" name="pass2" id="pass2" class="form-control" required>
                                        <input type="hidden" name="id_petugas" value="<?= $e->id_petugas; ?>">
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
        <?php } else {; ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Akun operator</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/account/operator/insert') ?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="user">Username</label>
                            <input type="text" name="user" id="user" pattern="[a-z]{3,15}" title="Gunakan lowercase" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="pass">Password</label>
                            <input type="text" name="pass" id="pass" required class="form-control">
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
                <h6 class="m-0 font-weight-bold text-primary">Data Akun operator</h6>
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
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach ($operator as $o) {; ?>
                                <tr>
                                    <td><?= $no += 1; ?></td>
                                    <td><?= $o->nama_petugas ?></td>
                                    <td><?= $o->username ?></td>
                                    <td>
                                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $o->id_petugas) {; ?>
                                            <button type="button" class="text-warning btn btn-disable" disabled>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="text-danger btn" disabled>
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="text-muted btn" disabled>
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                        <?php } else { ?>
                                            <a href="<?= base_url('/admin/account/operator/?edit=' . $o->id_petugas) ?>" class="text-warning btn">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" data-toggle="modal" data-target="#hapus_<?= $o->id_petugas ?>" class="text-danger btn">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <!-- Modal hapus-->
                                <div class="modal fade" id="hapus_<?= $o->id_petugas ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h5><?= "Yakin ingin menghapus akun " . $o->nama_petugas . " ?"; ?></h5>
                                                    <br>
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-dismiss="modal">Cancel</button>
                                                    <a href="<?= base_url('/admin/account/operator/' . $o->id_petugas . '/delete') ?>" class="btn btn-sm btn-danger">Hapus</a>
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


<?= $this->endsection('konten'); ?>