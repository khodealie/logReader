<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportLog extends Command
{
    private array $insertArray = [];
    private int $insertCounter = 0;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:log {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import log file via log file address';

    private function stringTime2Timestamp(string $stringTime): int
    {
        $temp = explode(":", $stringTime, 2);
        $date = str_replace('/', '-', str_replace('[', '', $temp[0]));
        $time = str_replace(']', '', $temp[1]);
        return strtotime($date . ' ' . $time);
    }

    private function queryBuilder(array $newInsertData): void
    {
        $this->insertArray[] = $newInsertData;
        if (count($this->insertArray) >= 10000) {
            DB::table('logs')->insert($this->insertArray);
            $this->insertArray = [];
            echo ($this->insertCounter + 10000) . " rows added\n";
            $this->insertCounter += 10000;
        }
    }

    private function flushInsertArray()
    {
        if (count($this->insertArray) > 0) {
            DB::table('logs')->insert($this->insertArray);
            echo ($this->insertCounter + count($this->insertArray)) . " rows added\n";
        }
    }

    private function logString2LogArray(string $logLine): void
    {
        $logLineExplode = explode(' ', $logLine);
        try {
            $this->queryBuilder([
                'service' => $logLineExplode[0],
                'status' => str_replace("\n", '', $logLineExplode[6]),
                'method' => str_replace('"', '', $logLineExplode[3]),
                'endpoint' => $logLineExplode[4],
                'created_at' => date('Y-m-d H:i:s', $this->stringTime2Timestamp($logLineExplode[2]))
            ]);
        } catch (\Exception) {
            echo "=> " . $logLine . " NOT IMPORTED!\n";
        }
    }

    public function handle(): int
    {
        $file = fopen($this->argument("file"), "r");
        while (!feof($file)) {
            $this->logString2LogArray(fgets($file));
        }
        $this->flushInsertArray();
        echo "\nimporting log file finished \n";
        return Command::SUCCESS;
    }
}
