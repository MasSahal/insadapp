<?= $this->extend('admin/template'); ?>

<?= $this->section('konten'); ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Transaksi Sewa/Beli</h1>
    <a href="<?= base_url('/admin/penyewaan/generate-penyewaan') ?>" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Laporan</a>
</div>

<?php
if (isset($_GET['detail'])) {
    echo view('admin/data/detail_penyewaan', $detail);
}
?>

<div class="row">
    <div class="col-12">

        <?php if (isset($_SESSION['type'])) { ?>
            <div class="alert alert-<?= session()->type; ?> alert-dismissible fade show mb-2" role="alert">
                <?= session()->message; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <div class="card shadow border-left-success ">
            <div class="card-header">
                Table Data Transaksi Sewa/Beli
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <!-- <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#tambah">
                            <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                            Tambah
                        </button> -->
                        <a href="<?= base_url('admin/penyewaan/form-penyewaan') ?>" class="btn btn-success btn-sm">
                            <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                            Tambah
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Tanggal Dikembalikan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    <?php foreach ($penyewaan as $p) { ?>
                                        <tr>
                                            <td><?= $no += 1; ?></td>
                                            <td><?= $p->nama; ?></td>
                                            <td><small><?= tanggal($p->tanggal_penyewaan); ?></small></td>
                                            <td><small><?= tanggal($p->jatuh_tempo); ?></small></td>
                                            <td><?= ($p->tanggal_kembali == null) ?  " <i class='text-danger'>belum dikembalikan</i> " : '<small>' . tanggal($p->tanggal_kembali) . '</small>'; ?></td>
                                            <td>
                                                <?php if ($p->status_penyewaan == 'dipinjam') {; ?>
                                                    <span class="text-warning"><?= $p->status_penyewaan; ?></span>
                                                <?php } else { ?>
                                                    <span class="text-success"><?= $p->status_penyewaan; ?></span>
                                                <?php } ?>

                                            </td>
                                            <td>
                                                <?php if (isset($_GET['detail']) && $p->id_penyewaan == $_GET['detail']) {; ?>
                                                    <button class="btn" disabled>
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </button>
                                                    <?php if ($p->status_penyewaan == 'disewa') {; ?>
                                                        <button class="btn" disabled><i class="fa fa-check" aria-hidden="true"></i></button>
                                                    <?php }; ?>
                                                <?php } else { ?>
                                                    <form action="<?= base_url('/admin/penyewaan/kembalikan_penyewaan') ?>" method="post">
                                                        <a href="<?= base_url('admin/penyewaan?detail=' . $p->id_penyewaan) ?>" class="btn">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </a>
                                                        <?php if ($p->status_penyewaan == 'disewa') {; ?>
                                                            <input type="hidden" name="id_penyewaan" value="<?= $p->id_penyewaan; ?>">
                                                            <button type="submit" class="btn" onclick="return confirm('Tandai penyewaan telah dikembalikan?')"><i class="fa fa-check text-success" aria-hidden="true"></i></button>
                                                        <?php }; ?>
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah penyewaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection('konten'); ?>