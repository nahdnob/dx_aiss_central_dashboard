<?php

namespace App\Services\Production;

use Illuminate\Support\Facades\Cache;

/**
 * Menyimpan status sinkronisasi file per line (product_in / product_out).
 *
 * "Caught up" = program sudah membaca file sampai baris terakhir (kalibrasi selesai).
 * Selama kalibrasi berjalan, atau jika belum pernah selesai sama sekali,
 * status dianggap BELUM caught up.
 */
class SyncState
{
    public const IN  = 'in';
    public const OUT = 'out';

    public static function markCalibrating(string $source, int $lineId): void
    {
        Cache::forever(self::key($source, $lineId), false);
    }

    public static function markCaughtUp(string $source, int $lineId): void
    {
        Cache::forever(self::key($source, $lineId), true);
    }

    public static function isCaughtUp(string $source, int $lineId): bool
    {
        return Cache::get(self::key($source, $lineId), false) === true;
    }

    /** Product in DAN product out untuk line ini sudah terbaca sampai akhir. */
    public static function isLineCaughtUp(int $lineId): bool
    {
        return self::isCaughtUp(self::IN, $lineId) && self::isCaughtUp(self::OUT, $lineId);
    }

    private static function key(string $source, int $lineId): string
    {
        return "production-sync:caught-up:{$source}:{$lineId}";
    }
}
