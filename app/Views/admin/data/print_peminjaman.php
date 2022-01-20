<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Data penyewaan</title>
    <style>
        table,
        tr,
        td,
        th {
            border: 1px solid black;
        }

        table {
            background: #fafafa;
            position: center;
            font-family: Helvetica, Arial, Segoe UI, Segoe UI Emoji;
            border-collapse: collapse;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        th {
            background: #bbbbbb;
            padding: 10px;
        }

        td {
            padding: 5px
        }
    </style>
</head>

<body>
    <table width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Dikembalikan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 0; ?>
            <?php foreach ($penyewaan as $p) { ?>
                <tr>
                    <td><?= $no += 1; ?></td>
                    <td><?= $p->nama_pegawai; ?></td>
                    <td><?= $p->nama; ?></td>
                    <td><?= $p->jumlah_pinjam; ?></td>
                    <td><?= $p->tanggal_penyewaan; ?></td>
                    <td><?= ($p->tanggal_kembali == null) ?  " - " : $p->tanggal_kembali; ?></td>
                    <td>
                        <?php if ($p->status_penyewaan == 'dipinjam') {; ?>
                            <span class="text-warning"><?= $p->status_penyewaan; ?></span>
                        <?php } else { ?>
                            <span class="text-success"><?= $p->status_penyewaan; ?></span>
                        <?php } ?>

                    </td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>