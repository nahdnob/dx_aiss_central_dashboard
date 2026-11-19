<?php

namespace App\Support;

use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

/**
 * Cek apakah folder (terutama share jaringan \\HOST\...) bisa diakses,
 * dengan batas waktu.
 *
 * Fungsi bawaan PHP (is_dir, file_exists, file) bisa menunggu tanpa batas
 * saat share jaringan tidak merespons (mis. kredensial belum tersimpan),
 * sehingga command scheduler macet tanpa log. Pengecekan dilakukan di
 * proses terpisah supaya bisa dihentikan bila melewati timeout.
 */
class NetworkPath
{
    /**
     * @return array{ok: bool, reason: ?string}
     */
    public static function check(string $path, int $timeoutSeconds = 10): array
    {
        $path = rtrim($path, '\\/');

        // Path lokal tidak perlu proses terpisah.
        if (!str_starts_with($path, '\\\\') && !str_starts_with($path, '//')) {
            return is_dir($path)
                ? ['ok' => true, 'reason' => null]
                : ['ok' => false, 'reason' => 'not_found'];
        }

        $process = Process::fromShellCommandline(
            PHP_OS_FAMILY === 'Windows'
                ? 'if exist "' . $path . '\\" (exit 0) else (exit 1)'
                : 'test -d ' . escapeshellarg($path)
        );
        $process->setTimeout($timeoutSeconds);

        try {
            $process->run();
        } catch (ProcessTimedOutException) {
            return ['ok' => false, 'reason' => "timeout_{$timeoutSeconds}s"];
        }

        return $process->isSuccessful()
            ? ['ok' => true, 'reason' => null]
            : ['ok' => false, 'reason' => 'not_found_or_access_denied'];
    }
}
