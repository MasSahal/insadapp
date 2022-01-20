<?= $this->extend('admin/template'); ?>
<?= $this->section('konten'); ?>
<!-- CODE HERE -->
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

        <div class="card mb-3">
            <div class="card-header">
                Keranjang Checkout
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr class="thead-light">
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Qty</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>

                                <?php $no = 0;
                                $total = 0;
                                $sewa = 0;
                                foreach ($cart as $c) {
                                    $total = $total + ($c->harga * $c->qty);
                                ?>
                                    <tr>
                                        <td><?= $no += 1; ?></td>
                                        <td><?= $c->nama_produk; ?></td>
                                        <td><?= $c->qty; ?></td>
                                        <td><?= $c->jenis; ?></td>
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
                                <tr>
                                    <td colspan="4" class="text-right">
                                        Biaya Sewa <span id="hari">1 Hari</span>
                                    </td>
                                    <td colspan="2" class="text-left">
                                        <span id="sewa"><?= rupiah($sewa); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right">
                                        Total
                                    </td>
                                    <td colspan="2" class="text-left">
                                        <strong id="total" total="<?= $total + $sewa; ?>"><?= rupiah($total + $sewa); ?></strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="date">Hari Pengembalian Sewa Barang</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                            <small>Masukan Tanggal Pengembalian</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        Lama Sewa : <span id="sewa"></span> <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                Form Tambah Transaksi Produk
                <!-- Button trigger modal
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modelId">
                    <i class="fa fa-cart-arrow-down fa-fw" aria-hidden="true"></i>
                    Keranjang
                </button> -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Jenis</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach ($produk as $p) {
                                if ($p->jumlah == 0) {
                                    $disable = "disabled";
                                } else {
                                    $disable = "";
                                }
                            ?>
                                <tr>
                                    <td><?= $no += 1; ?></td>
                                    <td><?= $p->jenis ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/produk?detail=' . $p->id_produk) ?>" class="text-info font-weight-bold">
                                            <?= $p->nama ?>
                                        </a>
                                    </td>
                                    <td class="text-right"><?= rupiah($p->harga) ?></td>
                                    <form action="<?= base_url('/admin/penyewaan/add-cart') ?>" method="post">
                                        <td>
                                            <div class="form-group">
                                                <input type="number" name="qty" id="qty" class="form-control form-control-sm" min="0" max="<?= $p->jumlah; ?>" placeholder="Masukan qty" required <?= $disable; ?>>
                                                <input type="hidden" name="id_produk" id="id_produk" value="<?= $p->id_produk; ?>">
                                                <input type="hidden" name="nama" id="nama" value="<?= $p->nama; ?>">
                                                <input type="hidden" name="jenis" id="jenis" value="<?= $p->jenis; ?>">
                                                <input type="hidden" name="harga" id="harga" value="<?= $p->harga; ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-success" <?= $disable; ?>>
                                                <i class="fa fa-plus fa-fw" aria-hidden="true"></i>
                                                Tambahkan
                                            </button>
                                        </td>
                                    </form>
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

<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CheckOut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Selesaikan</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('konten'); ?>

<?= $this->section('js'); ?>
<!-- CODE HERE -->
<script>
    $(document).ready(function() {

        function rupiah(rp) {
            var number_string = rp.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return rupiah;
        }

        $('#date').on('change', function() {
            var today = new Date();
            var now = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();

            var date = new Date($('#date').val());

            var from = new Date(now);
            var to = new Date(date);
            var millisBetween = to.getTime() - from.getTime();
            var days = millisBetween / (1000 * 3600 * 24);

            var res = Math.round(Math.abs(days));
            var sewa = $('#harga').attr('harga');
            // if (typeof sewa.foo == 'undefined') {
            //     var sewa = 0;
            // }
            var total = parseInt($('#total').attr('total'))
            console.log(total)
            var total_akhir = total + (res * sewa);

            $('#hari').html(res + " Hari")
            $('#sewa').html(rupiah(res * sewa))
            $('#total').html("Rp" + rupiah(total_akhir));
            alert(rupiah(total_akhir))
        });
    })
</script>
<?= $this->endSection('js'); ?>