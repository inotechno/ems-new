<?php

namespace App\Helpers;

class HolidayHelper
{
    public static function isHoliday($date)
    {
        $holidays = self::getHolidays(date('Y', strtotime($date)));

        // Cek apakah tanggal termasuk hari libur nasional
        foreach ($holidays as $holiday) {
            if (
                $holiday['holiday_date'] === $date &&
                $holiday['is_national_holiday'] === true
            ) {
                return true;
            }
        }

        // Cek akhir pekan (Sabtu = 6, Minggu = 7)
        $dayNumber = date('N', strtotime($date));
        if ($dayNumber == 6 || $dayNumber == 7) {
            return true;
        }

        return false;
    }

    protected static function getHolidays($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }

        $ch = curl_init(env('API_HOLIDAY_URL') . '/api?year=' . $year);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: Mozilla/5.0 (compatible; LaravelBot/1.0; +https://ruang.test)'
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return json_decode($response, true);
        }

        return []; // fallback: tidak ada libur
    }

    // Get Working Days
    public static function getWorkingDays($startDate, $endDate)
    {
        $workingDays = 0;
        $holidayCache = [];

        for ($date = strtotime($startDate); $date <= strtotime($endDate); $date = strtotime('+1 day', $date)) {
            $dayNumber = date('N', $date);

            // Skip Sabtu & Minggu
            if ($dayNumber >= 6) {
                continue;
            }

            $year = date('Y', $date);

            // Ambil data libur tahun ini jika belum
            if (!isset($holidayCache[$year])) {
                $holidayCache[$year] = self::getHolidays($year);
            }

            // Cek apakah tanggal ini adalah hari libur nasional
            $isHoliday = false;
            foreach ($holidayCache[$year] as $holiday) {
                if ($holiday['holiday_date'] === date('Y-m-d', $date)) {
                    $isHoliday = true;
                    break;
                }
            }

            if (!$isHoliday) {
                $workingDays++;
            }
        }

        return $workingDays;
    }

}
