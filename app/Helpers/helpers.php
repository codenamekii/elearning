<?php

use Carbon\Carbon;

function hariIndo()
{
    $hari = Carbon::now()->format('l');
    switch ($hari) {
        case 'Sunday':
            return 'Minggu';
        case 'Monday':
            return 'Senin';
        case 'Tuesday':
            return 'Selasa';
        case 'Wednesday':
            return 'Rabu';
        case 'Thursday':
            return 'Kamis';
        case 'Friday':
            return "Jum'at";
        case 'Saturday':
            return 'Sabtu';
        default:
            return '';
    }
}

function waktuSekarang()
{
    return Carbon::now();
}
