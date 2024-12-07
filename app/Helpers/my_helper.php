<?php


function role_staff_umum()
{
    if (auth()->user()->role !== 'staff umum') {
        return false;
    } else {
        return true;
    }
}
function role_staff_keuangan()
{
    if (auth()->user()->role !== 'staff keuangan') {
        return false;
    } else {
        return true;
    }
}

function formatRupiah($number, $decimals = 0)
{
    // Mengecek apakah input adalah angka yang valid
    if (!is_numeric($number)) {
        return 'Invalid number';
    }
    $number = floatval($number);

    // Format angka dengan pemisah ribuan titik dan koma untuk desimal
    return 'Rp ' . number_format($number, $decimals, ',', '.');
}

function formatTanggal($date, $format = 'd-m-Y', $locale = 'id')
{
    if (!$date) {
        return null; // Mengembalikan null jika tanggal kosong
    }

    try {
        // Set locale jika ada
        if ($locale) {
            Carbon\Carbon::setLocale($locale);
        }

        // Konversi ke Carbon dan format
        return Carbon\Carbon::parse($date)->translatedFormat($format);
    } catch (\Exception $e) {
        return null; // Jika gagal parsing tanggal
    }
}
