<?= $this->extend('admin/template'); ?>

<?= $this->section('konten'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data jenis</h1>
    <a href="<?= base_url('/admin/jenis/generate-jenis') ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan</a>
</div>

<!-- info data produk -->
<div class="row">
    <div class="col-md-4">
        <?php if (isset($_GET['edit'])) {; ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Jenis</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/insert-edit-jenis') ?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required value="<?= $detail->nama_jenis; ?>">
                            <input type="hidden" name="id_jenis" value="<?= $detail->id_jenis; ?>">
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
                    <h6 class="m-0 font-weight-bold text-primary">Tambah jenis Sekolah</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('/admin/insert-jenis') ?>" method="post">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
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
                <h6 class="m-0 font-weight-bold text-primary">Data Jenis</h6>
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
                                <th>Name Jenis</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Name Jenis</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach ($jenis as $dr) {; ?>
                                <tr>
                                    <td><?= $no += 1; ?></td>
                                    <td><?= $dr->nama_jenis ?></td>
                                    <td><?= $dr->keterangan ?></td>
                                    <td>
                                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $dr->id_jenis) {; ?>
                                            <button type="button" class="text-warning btn btn-disable" disabled>
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="text-danger btn" disabled>
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        <?php } else { ?>
                                            <a href="<?= base_url('/admin/jenis/?edit=' . $dr->id_jenis) ?>" class="text-warning btn">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php $pilih = $this- ?>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <!-- Modal hapus-->
                                <div class="modal fade" id="hapus_<?= $dr->id_jenis ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="text-center">
                                                    <h5><?= "Yakin ingin menghapus jenis " . $dr->nama_jenis . " ?"; ?></h5>
                                                    <br>
                                                    <button type="button" class="btn btn-sm btn-outline-dark" data-dismiss="modal">Cancel</button>
                                                    <a href="<?= base_url('/admin/jenis/' . $dr->id_jenis . '/delete') ?>" class="btn btn-sm btn-danger">Hapus</a>
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

<div class="card-body">
                <div class="row">
                    <h4></h4>
                    <?php foreach ($produk as $p) {
                        if ($p->jumlah == 0) {
                            $disable = "disabled";
                        } else {
                            $disable = "";
                        }
                    ?>

                        <div class="col-xs-4 col-sm-3 col-md-3 m-1">

                            <div class="card text-left">
                                <img class="card-img-top" src="<?= base_url('public/img/produk/' . $p->gambar) ?>" alt="<?= $p->gambar; ?>">
                                <div class="card-body">
                                    <strong class="card-title text-primary"><?= $p->nama; ?></strong>
                                    <p class="card-text text-warning"><?= rupiah($p->harga); ?></p>
                                    <form action="<?= base_url('/admin/penyewaan/add-cart') ?>" method="post">
                                        <div class="form-group">
                                            <label for="qty">Qty</label>
                                            <input type="number" name="qty" id="qty" class="form-control form-control-sm" min="0" max="<?= $p->jumlah; ?>" placeholder="Masukan qty" required <?= $disable; ?>>
                                            <input type="hidden" name="id_produk" id="id_produk" value="<?= $p->id_produk; ?>">
                                            <input type="hidden" name="nama" id="nama" value="<?= $p->nama; ?>">
                                            <input type="hidden" name="jenis" id="jenis" value="<?= $p->jenis; ?>">
                                            <input type="hidden" name="harga" id="harga" value="<?= $p->harga; ?>">
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success" <?= $disable; ?>>
                                            <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                                            Tambahkan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    <?php }; ?>
                </div>
            </div>
<?= $this->endsection('konten'); ?>

foreach ($cart as $c) {
                                    $total = $total + ($c->harga * $c->qty);
                                ?>
                                    <tr>
                                        <td><?= $no += 1; ?></td>
                                        <td><?= $c->nama_produk; ?></td>
                                        <td><?= $c->qty; ?></td>
                                        <td id="harga" harga="<?= $c->harga; ?>">
                                            <?= rupiah($c->harga); ?>

                                            <?php if ($c->jenis == "sewa") {
                                                $sewa = $sewa + $c->harga;
                                            } ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/penyewaan/del-cart/' . $c->id_produk) ?>" class="btn text-danger" onclick="return confirm('Yakin ingin menghapus ini?')">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }; ?>