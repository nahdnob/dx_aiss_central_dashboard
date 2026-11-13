<?php

namespace App\Services\Production;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ShiftResolver
{
    // id shift => nama folder di server pokayoke/kanban
    private const FOLDERS = [1 => 'DAY', 2 => 'NIGHT'];

    private ?array $shifts = null;

    /** Daftar shift terurut berdasarkan jam mulai: [id, start] */
    private function load(): array
    {
        if ($this->shifts !== null) {
            return $this->shifts;
        }

        return $this->shifts = DB::table('work_hours')
            ->orderBy('shift_id')
            ->orderBy('hour_number')
            ->get()
            ->groupBy('shift_id')
            ->map(fn ($rows) => [
                'id'    => (int) $rows->first()->shift_id,
                'start' => $rows->first()->time_start,   // jam ke-1
            ])
            ->sortBy('start')
            ->values()
            ->all();
    }

    public function current(Carbon $now): ?array
    {
        $time   = $now->format('H:i:s');
        $shifts = $this->load();
        $count  = count($shifts);

        foreach ($shifts as $i => $shift) {
            $from = $shift['start'];
            // shift berlaku sampai shift berikutnya mulai (wrap ke shift pertama)
            $to   = $shifts[($i + 1) % $count]['start'];

            $overnight = $from > $to;

            $inShift = $overnight
                ? ($time >= $from || $time < $to)
                : ($time >= $from && $time < $to);

            if (!$inShift) {
                continue;
            }

            return [
                'id'          => $shift['id'],
                'folder'      => self::FOLDERS[$shift['id']] ?? null,
                'folder_date' => ($overnight && $time < $to)
                    ? $now->copy()->subDay()
                    : $now->copy(),
            ];
        }

        return null;
    }

    /** Awal hari kerja (07:35), dipakai untuk menentukan +1 hari pada time_in / time_out */
    public function workdayStart(): string
    {
        return $this->load()[0]['start'];
    }
}