<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseBackupController extends Controller
{
    /**
     * Realiza un backup de la base de datos usando mysqldump y lo descarga.
     */
    public function backup()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');

        $filename = 'backup_' . date('Ymd_His') . '.sql';
        $tempPath = storage_path('app/' . $filename);

        $command = [
            'mysqldump',
            '--host=' . $host,
            '--port=' . $port,
            '--user=' . $username,
            '--password=' . $password,
            $database,
        ];

        $process = new Process($command);
        $process->setTimeout(3600); // Aumentar el timeout para bases de datos grandes (opcional)

        try {
            $process->run();

            // Verificar si el comando se ejecutó exitosamente
            if (!$process->isSuccessful()) {
                Log::error("Error al crear el backup:\n" . $process->getErrorOutput());
                return redirect()->back()->withErrors("Error al crear el backup. Detalles: " . $process->getErrorOutput());
            }

            // Guardar la salida del backup en el archivo temporal
            file_put_contents($tempPath, $process->getOutput());

            return response()->download($tempPath, $filename)->deleteFileAfterSend(true);

        } catch (ProcessFailedException $exception) {
            Log::error("Error al ejecutar el comando de backup:\n" . $exception->getMessage());
            return redirect()->back()->withErrors("Error interno al ejecutar el backup: " . $exception->getMessage());
        } catch (\Exception $e) {
            Log::error("Error inesperado durante el backup:\n" . $e->getMessage());
            return redirect()->back()->withErrors("Ocurrió un error inesperado durante el backup.");
        }
    }

    /**
     * Restaura la base de datos a partir de un archivo de backup.
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql'
        ]);

        $file = $request->file('backup_file');
        $tempPath = $file->getRealPath();

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');

        $command = [
            'mysql',
            '--host=' . $host,
            '--port=' . $port,
            '--user=' . $username,
            '--password=' . $password,
            $database,
            '<' . $tempPath, // Redirigir la entrada desde el archivo
        ];

        $process = new Process($command);
        $process->setTimeout(3600); // Aumentar el timeout para bases de datos grandes (opcional)

        try {
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error("Error al restaurar la base de datos:\n" . $process->getErrorOutput());
                return redirect()->back()->withErrors("Error al restaurar la base de datos. Detalles: " . $process->getErrorOutput());
            }

            return redirect()->back()->with('success', 'Base de datos restaurada correctamente.');

        } catch (ProcessFailedException $exception) {
            Log::error("Error al ejecutar el comando de restauración:\n" . $exception->getMessage());
            return redirect()->back()->withErrors("Error interno al ejecutar la restauración: " . $exception->getMessage());
        } catch (\Exception $e) {
            Log::error("Error inesperado durante la restauración:\n" . $e->getMessage());
            return redirect()->back()->withErrors("Ocurrió un error inesperado durante la restauración.");
        }
    }
}