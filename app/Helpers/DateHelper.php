<?php

use Carbon\Carbon;

// Format tanggal ke dalam format yang lebih mudah dibaca.
if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'd-m-Y')
    {
        return Carbon::parse($date)->format($format);
    }
}

// Hitung selisih hari antara dua tanggal.
if (!function_exists('daysBetween')) {
    function daysBetween($startDate, $endDate)
    {
        return Carbon::parse($startDate)->diffInDays(Carbon::parse($endDate));
    }
}

// Tambahkan sejumlah hari ke sebuah tanggal.
if (!function_exists('addDays')) {
    function addDays($date, $days)
    {
        return Carbon::parse($date)->addDays($days)->toDateString();
    }
}

// Periksa apakah sebuah tanggal berada di masa depan.
if (!function_exists('isFuture')) {
    function isFuture($date)
    {
        return Carbon::parse($date)->isFuture();
    }
}

// Dapatkan tanggal awal dan akhir dari bulan yang diberikan.
if (!function_exists('getMonthStartAndEnd')) {
    function getMonthStartAndEnd($date)
    {
        $carbonDate = Carbon::parse($date);
        return [
            'start' => $carbonDate->startOfMonth()->toDateString(),
            'end' => $carbonDate->endOfMonth()->toDateString(),
        ];
    }
}

// Ubah tanggal ke dalam format Waktu yang Berjalan (Time Ago).
if (!function_exists('timeAgo')) {
    function timeAgo($date)
    {
        return Carbon::parse($date)->diffForHumans();
    }
}

// Konversi tanggal ke dalam format bahasa Indonesia.
if (!function_exists('toIndonesianDate')) {
    function toIndonesianDate($date, $withDay = false)
    {
        $carbonDate = Carbon::parse($date);
        $dayName = $carbonDate->format('l');
        $day = $carbonDate->format('d');
        $month = $carbonDate->format('F');
        $year = $carbonDate->format('Y');

        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu'
        ];

        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        $formattedDate = ($withDay ? $days[$dayName] . ', ' : '') . $day . ' ' . $months[$month] . ' ' . $year;

        return $formattedDate;
    }
}
