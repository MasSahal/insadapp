<?= $this->extend('admin/template'); ?>

<?= $this->section('konten'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Produk</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan</a>
</div>

<!-- info data produk -->
<div class="row">
    <div class="col-md-12">
        <?php if (isset($_SESSION['type'])) { ?>
            <div class="alert alert-<?= session()->type; ?> alert-dismissible fade show mb-2" role="alert">
                <?= session()->message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
    </div>

    <?php
    if (isset($_GET['detail'])) {
        echo view('admin/data/detail_produk', $detail);
    }
    ?>

    <div class="col-12">
        <div class="card shadow mb-4 border-left-success">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data Produk</h6>
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
                <div class="row mb-3">
                    <div class="col-12">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                            <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                            Tambah
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table" id="dataTable">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Jumlah</th>
                                        <th>Jenis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Status</th>
                                        <th>Jumlah</th>
                                        <th>Jenis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php $no = 0; ?>
                                    <?php foreach ($data_produk as $di) {; ?>
                                        <tr>
                                            <td><?= $no += 1; ?></td>
                                            <td><?= $di->nama ?></td>
                                            <td class="text-right"><?= rupiah($di->harga) ?></td>
                                            <td><?= $di->status ?></td>
                                            <td><?= $di->jumlah ?></td>
                                            <td><?= $di->jenis ?></td>
                                            <td>
                                                <button type="button" data-toggle="modal" data-target="#stok_<?= $di->id_produk ?>" class="text-success btn">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                                <button type="button" data-toggle="modal" data-target="#edit_<?= $di->id_produk ?>" class="text-warning btn">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <?php if (isset($_GET['detail']) && $_GET['detail'] == $di->id_produk) {; ?>
                                                    <!-- <button type="button" class="text-muted btn disabled" disabled>
                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="text-warning btn disabled" disabled>
                                                        <i class="fas fa-edit"></i>
                                                    </button> -->
                                                    <button type="button" class="text-danger btn disabled" disabled>
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="button" class="text-muted btn disabled" disabled>
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button type="button" data-toggle="modal" data-target="#hapus_<?= $di->id_produk ?>" class="text-danger btn">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                    <a href="<?= base_url('/admin/produk/?detail=' . $di->id_produk) ?>" class="text-muted btn">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
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
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Aset produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('/admin/insert-produk') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" name="harga" id="harga" class="form-control" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="jumlah">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="null" disabled selected>- Pilih status -</option>
                                    <option value="Ready Stok">Ready Stok</option>
                                    <option value="Pre-Order">Pre-Order</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis</label>
                                <select class="form-control" name="jenis" id="jenis" required>
                                    <option value="null" selected disabled>- Pilih Jenis -</option>
                                    <option value="beli">Beli</option>
                                    <option value="sewa">Sewa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="foto">Gambar</label>
                                <input type="file" class="form-control-file" name="foto" id="foto" placeholder="" required>
                                <small class="text-danger">Maks. 2mb - PNG, JPG, JPEG</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="ket">Keterangan</label>
                                <textarea class="form-control" name="ket" id="ket" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach ($data_produk as $di) {; ?>

    <!-- Modal hapus-->
    <div class="modal fade" id="hapus_<?= $di->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h5><?= "Yakin ingin menghapus aset " . $di->nama . " ?"; ?></h5>
                        <br>
                        <button type="button" class="btn btn-sm btn-outline-dark" data-dismiss="modal">Cancel</button>
                        <a href="<?= base_url('/admin/produk/' . $di->id_produk . '/delete') ?>" class="btn btn-sm btn-danger">Hapus</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal EDIT-->
    <div class="modal fade" id="edit_<?= $di->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Aset <?= $di->nama; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('/admin/insert-edit-produk') ?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <input type="hidden" name="id_produk" value="<?= $di->id_produk; ?>">
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $di->nama; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control" min="1" value="<?= $di->harga; ?>">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="Ready Stok" <?php ($di->status == 'Ready Stok') ? " selected" : ""; ?>>Ready Stok</option>
                                        <option value="Pre-Order" <?php ($di->status == 'Pre-Order') ? " selected" : ""; ?>>Pre-Order</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="jenis">Jenis</label>
                                    <select class="form-control" name="jenis" id="jenis">
                                        <option value="null" selected disabled>- Pilih Jenis -</option>
                                        <option value="beli" <?= ($di->jenis == "beli") ? " selected" : ""; ?>>Beli</option>
                                        <option value="sewa" <?= ($di->jenis == "sewa") ? " selected" : ""; ?>>Sewa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="ket">Keterangan</label>
                                    <textarea class="form-control" name="ket" id="ket" rows="3"><?= $di->keterangan; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal tambah stok-->
    <div class="modal fade" id="stok_<?= $di->id_produk ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Stok Produk <?= $di->nama; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('/admin/add-stock-produk') ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="id_produk" value="<?= $di->id_produk; ?>">
                        <div class="form-group">
                            <label for="jumlah">Stok Saat Ini</label>
                            <input type="text" disabled value="<?= $di->jumlah; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Tambah</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" autofocus>
                        </div>
                    </div>
                    <div class=" modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>
<?= $this->endsection('konten'); ?>