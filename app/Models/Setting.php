<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    // Fungsi untuk mendapatkan nilai setting
    public static function get($key, $default = null)
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    // Fungsi untuk meng-update nilai setting
    public static function set($key, $value)
    {
        Cache::forget('setting_' . $key);
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
