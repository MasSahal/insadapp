<?php foreach ($detail as $d) { ?>
    <!-- detail data produk -->

    <div class="col-12">
        <div class="card shadow mb-4 border-left-info">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Produk <?= $d->kode_produk; ?></h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="<?= base_url('./public/img/produk/' . $d->gambar); ?>" class="img-fluid" alt="<?= $d->gambar; ?>">
                        <button type="button" class="btn btn-info btn-sm mt-3" data-toggle="modal" data-target="#ubah">Ubah Gambar</button>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th>Kode Produk</th>
                                <td>:</td>
                                <td><?= $d->kode_produk; ?></td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td><?= $d->nama; ?></td>
                            </tr>
                            <tr>
                                <th>Harga</th>
                                <td>:</td>
                                <td><?= rupiah($d->harga); ?></td>
                            </tr>
                            <tr>
                                <th>Jenis</th>
                                <td>:</td>
                                <td><?= $d->jenis; ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>:</td>
                                <td><?= $d->status; ?></td>
                            </tr>
                            <tr>
                                <th>Jumlah</th>
                                <td>:</td>
                                <td><?= $d->jumlah; ?></td>
                            </tr>
                            <tr>
                                <th>Tanggal Masuk</th>
                                <td>:</td>
                                <td><?= tgl_indo($d->tanggal_register); ?></td>
                            </tr>
                            <tr>
                                <th>Dibuat Oleh</th>
                                <td>:</td>
                                <td><?= $d->nama_petugas; ?></td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>:</td>
                                <td>
                                    <p><?= $d->keterangan; ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= current_url() ?>" class="btn btn-sm btn btn-secondary">
                    <i class="fas fa-backward fa-fw"></i>
                    Kembali
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <?= jumlah_hari(date("Y-m-d"), date_format(date_create("2022-01-20"), "Y/m/d")); ?>
        </div>
    </div>

    <!-- Modal edit gambar-->
    <div class="modal fade" id="ubah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Gambar Produk <?= $d->nama; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('/admin/edit-image-produk') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="id_produk" value="<?= $d->id_produk; ?>">
                        <input type="hidden" name="nama" value="<?= $d->nama; ?>">
                        <input type="hidden" name="gambar" value="<?= $d->gambar; ?>">
                        <div class="form-group">
                            <label for="foto">Gambar</label>
                            <input type="file" class="form-control-file" name="foto" id="foto" placeholder="" required accept="image/*">
                            <small class="text-danger">Maks. 2mb - PNG, JPG, JPEG</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php } ?>