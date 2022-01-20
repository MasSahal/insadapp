<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Data Akun Aoperator</title>
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
                <th>Username</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 0; ?>
            <?php foreach ($operator as $p) {; ?>
                <tr>
                    <td><?= $no += 1; ?></td>
                    <td><?= $p->nama_petugas ?></td>
                    <td><?= $p->username ?></td>
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