<?php


function getAllMonths()
{
    $months = [
        ['number' => 1, 'name' => 'Januari'],
        ['number' => 2, 'name' => 'Februari'],
        ['number' => 3, 'name' => 'Maret'],
        ['number' => 4, 'name' => 'April'],
        ['number' => 5, 'name' => 'Mei'],
        ['number' => 6, 'name' => 'Juni'],
        ['number' => 7, 'name' => 'Juli'],
        ['number' => 8, 'name' => 'Agustus'],
        ['number' => 9, 'name' => 'September'],
        ['number' => 10, 'name' => 'Oktober'],
        ['number' => 11, 'name' => 'November'],
        ['number' => 12, 'name' => 'Desember']
    ];
    return $months ?? [];
}

function getMonthName($number)
{
    $months = [
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
        12 => 'Desember'
    ];

    return $months[$number];
}
