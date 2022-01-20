<?= $this->extend('admin/template'); ?>
<?= $this->section('konten'); ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Formulir Penyewaan Barang</h1>
</div>

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

        <div class="card mb-3 shadow border-left-success">
            <div class="card-header">
                Detail Penyewaan Barang
            </div>
            <form action="<?= base_url('admin/penyewaan/insert-penyewaan') ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-center mb-3" id="title"></h4>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr class="thead-light">
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Harga Sewa/hari</th>
                                        <th>Qty</th>
                                        <th>Amount</th>
                                        <th>Aksi</th>
                                    </tr>

                                    <tbody id="show_data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama" required>
                            </div>
                            <div class="form-group">
                                <label for="no_ktp">No KTP/NIK</label>
                                <input type="number" name="no_ktp" id="no_ktp" class="form-control" placeholder="Masukan no KTP" pattern="{16}" title="Masukan 16 Digit Nomor KTP/NIK" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="jatuh_tempo">Hari Pengembalian Sewa Barang</label>
                                <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control" required>
                                <small>Masukan Tanggal Pengembalian</small>
                            </div>
                            <div id="form"></div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right mx-2 mb-3">Selesaikan</button>
                    <button type="reset" class="btn btn-warning float-right mx-2 mb-3">
                        <i class="fa fa-recycle" aria-hidden="true"></i>
                        Refresh
                    </button>
                </div>
            </form>
        </div>
        <div class="card shadow border-left-danger">
            <div class="card-header">
                Form Tambah Transaksi Produk
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="dataTable">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>No</th>
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
                                    $btn = "btn-secondary";
                                } else {
                                    $disable = "";
                                    $btn = "btn-success";
                                }
                            ?>
                                <tr>
                                    <td><?= $no += 1; ?></td>
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
                                            <button type="submit" class="btn btn-sm <?= $btn; ?>" <?= $disable; ?>>
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
        var url = "<?= base_url(); ?>";

        function rupiah(rp) {
            var number_string = rp.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return "Rp" + rupiah + ",00";
        }

        //panggil data cart
        get_cart()

        function get_cart(hari_sewa = 1) {
            var jenis = 'sewa';
            $.ajax({
                type: "POST",
                // contentType: "application/json; charset=utf-8",
                url: "<?= base_url("admin/penyewaan/get-cart"); ?>",
                dataType: "json",
                async: true,
                data: {
                    jenis: jenis
                },
                success: function(data) {
                    var html = "";
                    var i;
                    var no = 1;
                    var total = 0;
                    var harga = 0;

                    var amount;
                    for (i = 0; i < data.length; i++) {
                        var url = "<?= base_url('admin/penyewaan/del-cart/'); ?>" + "/" + data[i].id_produk

                        //subtotal
                        amount = parseInt(data[i].harga) * parseInt(data[i].qty);

                        qty = parseInt(qty) + parseInt(data[i].qty);
                        harga = harga + (parseInt(data[i].harga) * parseInt(hari_sewa));
                        total = total + (parseInt(amount) * parseInt(hari_sewa));

                        html += '<tr>' +
                            '<td>' + no++ + '</td>' +
                            '<td>' + data[i].nama_produk + '</td>' +
                            '<td>' + rupiah(data[i].harga) + '/hari</td>' +
                            '<td>' + data[i].qty + '</td>' +
                            '<td>' + rupiah(amount) + '</td>' +
                            '<td class="text-center">' +
                            '<a href="' + url + '" class="btn text-danger btn-sm" onclick="return confirm(\'Yakin ingin menghapus ini?\')">' +
                            '<i class="fa fa-trash" aria-hidden="true"></i>' +
                            '<input type="hidden" name="id_produk[]" value="' + data[i].id_produk + '">' +
                            '<input type="hidden" name="nama_produk[]" value="' + data[i].nama_produk + '">' +
                            '<input type="hidden" name="harga[]" value="' + data[i].harga + '">' +
                            '<input type="hidden" name="qty[]" value="' + data[i].qty + '">' +
                            '</a>' +
                            '</td>' +
                            '</tr>';
                    }
                    html += '<tr><td colspan="4" class="text-right font-weight-bolder">Total Tagihan</td><td colspan="2" class="text-left">' + rupiah(total) + '</td></tr>'
                    $('#show_data').html(html);
                    $('#title').html("Rincian Penyewaan Selama " + hari_sewa + " Hari");
                    $('#form').html('<input type="hidden" name="jumlah_tagihan" value="' + total + '"><input type="hidden" name="hari" value="' + hari_sewa + '">');


                }
            });
        }

        $('#jatuh_tempo').on('change', function() {
            var today = new Date();
            var now = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();

            var date = new Date($('#jatuh_tempo').val());

            var from = new Date(now);
            var to = new Date(date);
            var millisBetween = to.getTime() - from.getTime();
            var days = millisBetween / (1000 * 3600 * 24);

            var res = Math.round(Math.abs(days));
            var hari_sewa = res;
            // if (typeof sewa.foo == 'undefined') {
            //     var sewa = 0;
            // }
            var total = parseInt($('#total').attr('total'))
            console.log(total)
            var total_akhir = total + (res * hari_sewa);

            $('#hari').html(res + " Hari")
            // $('#sewa').html(rupiah(res * hari_sewa))
            // $('#total').html(rupiah(total_akhir));
            // alert(rupiah(total_akhir))

            get_cart(hari_sewa)
        });

        var nama = [];
        $.ajax({
            type: "POST",
            url: url + "/admin/account/pelanggan/get-pelanggan",
            dataType: "JSON",
            success: function(data) {
                for (let i = 0; i < data.length; i++) {
                    nama.push(data[i].nama)
                }
                // alert(nama);
            }
        });

        $("#nama").autocomplete({
            source: nama
        });

    })
</script>
<?= $this->endSection('js'); ?>