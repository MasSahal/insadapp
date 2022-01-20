<?php foreach ($detail as $d); ?>
<!-- detail data produk -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Detail Admin <?= $d->nama_petugas; ?></h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Nama</th>
                        <td>:</td>
                        <td><?= $d->nama_petugas; ?></td>
                    </tr>
                    <tr>
                        <th>Kondisi</th>
                        <td>:</td>
                        <td><?= $d->kondisi; ?></td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td>:</td>
                        <td><?= $d->jumlah; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>:</td>
                        <td><?= $d->tanggal_register; ?></td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>:</td>
                        <td><?= $d->nama_jenis; ?></td>
                    </tr>
                    <tr>
                        <th>Ruangan</th>
                        <td>:</td>
                        <td><?= $d->nama_ruang; ?></td>
                    </tr>
                    <tr>
                        <th>Petugas Pengupload</th>
                        <td>:</td>
                        <td><?= $d->nama_petugas; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="table-responsive"></div>
    </div>
</div>