<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseBackupController extends Controller
{
    /**
     * Realiza un backup de la base de datos y lo descarga.
     */
    public function backup()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $mysqldumpPath = config('app.mysqldump_path', '/usr/bin/mysqldump'); // Ruta configurable en config/app.php

        $filename = 'backup_' . date('Ymd_His') . '.sql';
        $tempPath = storage_path('app/' . $filename);

        if (!file_exists($mysqldumpPath)) {
            Log::error('Error: La ruta a mysqldump no es válida: ' . $mysqldumpPath);
            return redirect()->back()->withErrors(['backup_error' => 'La herramienta de backup no se encuentra. Contacta al administrador.']);
        }

        $command = [
            $mysqldumpPath,
            '--host=' . $host,
            '--port=' . $port,
            '--user=' . $username,
            '--password=' . $password,
            $database,
        ];

        $process = new Process($command);
        $process->setTimeout(3600); // 1 hora de timeout

        try {
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            file_put_contents($tempPath, $process->getOutput());

            Log::info('Backup de la base de datos creado exitosamente: ' . $filename);

            return response()->download($tempPath, $filename)->deleteFileAfterSend(true);

        } catch (ProcessFailedException $e) {
            Log::error('Error al crear el backup: ' . $e->getMessage() . "\nOutput: " . $process->getErrorOutput());
            return redirect()->back()->withErrors(['backup_error' => 'Ocurrió un error al crear la copia de seguridad de la base de datos. Por favor, revisa los logs para más detalles.']);
        } catch (\Exception $e) {
            Log::error('Error inesperado durante el backup: ' . $e->getMessage());
            return redirect()->back()->withErrors(['backup_error' => 'Ocurrió un error inesperado durante el backup.']);
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

        $backupFile = $request->file('backup_file');
        $tempPath = $backupFile->getRealPath();
        $originalFilename = $backupFile->getClientOriginalName();

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $mysqlPath = config('app.mysql_path', '/usr/bin/mysql'); // Ruta configurable en config/app.php

        if (!file_exists($mysqlPath)) {
            Log::error('Error: La ruta a mysql no es válida: ' . $mysqlPath);
            return redirect()->back()->withErrors(['restore_error' => 'La herramienta de restauración no se encuentra. Contacta al administrador.']);
        }

        $command = [
            $mysqlPath,
            '--host=' . $host,
            '--port=' . $port,
            '--user=' . $username,
            '--password=' . $password,
            $database,
        ];

        $process = new Process($command);
        $process->setInput(file_get_contents($tempPath));
        $process->setTimeout(3600); // 1 hora de timeout

        try {
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            Log::info('Base de datos restaurada exitosamente desde: ' . $originalFilename);

            return redirect()->back()->with('success', 'Base de datos restaurada correctamente.');

        } catch (ProcessFailedException $e) {
            Log::error('Error al restaurar la base de datos desde ' . $originalFilename . ': ' . $e->getMessage() . "\nOutput: " . $process->getErrorOutput());
            return redirect()->back()->withErrors(['restore_error' => 'Ocurrió un error al restaurar la base de datos. Por favor, revisa los logs para más detalles.']);
        } catch (\Exception $e) {
            Log::error('Error inesperado durante la restauración: ' . $e->getMessage());
            return redirect()->back()->withErrors(['restore_error' => 'Ocurrió un error inesperado durante la restauración.']);
        }
    }
}