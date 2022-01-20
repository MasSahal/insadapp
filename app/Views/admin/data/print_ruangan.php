<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Data Ruangan</title>
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
                <th>Name Ruangan</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 0; ?>
            <?php foreach ($ruangan as $dr) {; ?>
                <tr>
                    <td><?= $no += 1; ?></td>
                    <td><?= $dr->nama_ruang ?></td>
                    <td><?= $dr->keterangan ?></td>
                </tr>
            <?php
            }; #tutup foreach
            ?>
        </tbody>
    </table>

    <script>
        window.print();
    </script>
</body>

</html>