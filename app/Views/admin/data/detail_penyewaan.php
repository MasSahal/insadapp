<?php foreach ($detail as $d); ?>
<!-- detail data produk -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4 border-left-primary">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail penyewaan <?= $d->id_penyewaan; ?></h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>ID Penyewaan</th>
                        <td>:</td>
                        <td><?= $d->id_penyewaan; ?></td>
                    </tr>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td>:</td>
                        <td><?= $d->nama; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Barang Disewa</th>
                        <td>:</td>
                        <td><?= count($detail2); ?> Produk</td>
                    </tr>
                    <tr>
                        <th>Tanggal sewa</th>
                        <td>:</td>
                        <td><?= $d->tanggal_penyewaan; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Jatuh Tempo</th>
                        <td>:</td>
                        <td><?= $d->jatuh_tempo; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali</th>
                        <td>:</td>
                        <td><?= ($d->tanggal_kembali == null) ?  " - " : $d->tanggal_kembali; ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:</td>
                        <td>
                            <?php if ($d->status_penyewaan == 'disewa') {; ?>
                                <span class="text-warning"><?= $d->status_penyewaan; ?></span>
                            <?php } else { ?>
                                <span class="text-success"><?= $d->status_penyewaan; ?></span>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
                <br>
                <div class="table-responsive px-3">
                    <table class="table table-striped table-bordered" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga Sewa/hari</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <?php

                        $no = 0;
                        foreach ($detail2 as $d2) { ?>
                            <tr>
                                <td><?= $no += 1; ?></td>
                                <td><?= $d2->nama_produk; ?></td>
                                <td><?= $d2->qty; ?></td>
                                <td><?= $d2->harga; ?></td>
                            </tr>
                        <?php }; ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="table-responsive"></div>
    </div>
</div>