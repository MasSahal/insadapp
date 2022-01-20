<?php
function gabung_kode($char)
{
    $gabung = str_split('-', $char);
    dd($gabung);
    return $gabung[0] . $gabung[1];
}

function slug($str)
{
    return strtolower(str_replace([" ", "/", "_", "+", "-", ".", ","], "-", $str));
}

function rupiah($bil)
{
    return "Rp" . number_format($bil, 2, ",", ".");
}

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tahun
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tanggal

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

function jumlah_hari($from, $to)
{
    $now = strtotime($from);
    $your_date = strtotime($to);
    $datediff = $your_date - $now;

    echo round($datediff / (60 * 60 * 24));
}

function tanggal($waktu, $mark = ",", $jam = false)
{
    $hari_array = array(
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    );
    $hr = date('w', strtotime($waktu));
    $hari = $hari_array[$hr];
    $tanggal = date('j', strtotime($waktu));
    $bulan_array = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    );
    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));
    $jam = date('H:i:s', strtotime($waktu));

    //untuk menampilkan hari, tanggal bulan tahun jam
    //return "$hari, $tanggal $bulan $tahun $jam";

    //untuk menampilkan hari, tanggal bulan tahun
    if ($jam == true) {
        return $hari . "$mark $tanggal $bulan $tahun - Pukul $jam";
    } else {
        return $hari . "$mark $tanggal $bulan $tahun";
    }
}
