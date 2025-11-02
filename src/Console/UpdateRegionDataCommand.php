<?php

namespace WuriN7i\IdRefs\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use WuriN7i\IdRefs\Models\Region;

class UpdateRegionDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idrefs:update-region {--S|source}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update region data';

    protected $totalRows;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $source = $this->option('source');
        $prompt = 'Do you want to download and populate region data from github.com/cahyadsn/wilayah?';

        if (! $source && $this->confirm($prompt, true)) {
            $source = 'https://raw.githubusercontent.com/cahyadsn/wilayah/master/db/wilayah.sql';
        }

        if ($source) {
            $this->downloadAndExecSource($source);
            $this->repairSourceData();
            $this->transformData();
            $this->finish();
        }
    }

    protected function downloadAndExecSource(string $source): void
    {
        $this->info('Downloading source...');
        $contents = Http::get($source)->body();
        Storage::disk('local')->put('tmp/source.sql', $contents);

        $this->comment('Source downloaded. Executing...');
        DB::unprepared(Storage::disk('local')->get('tmp/source.sql'));

        $this->comment('Source executed.');
    }

    protected function repairSourceData(): void
    {
        DB::unprepared('ALTER TABLE wilayah CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
        DB::unprepared("UPDATE wilayah SET kode = CONCAT(kode, '0') WHERE kode REGEXP '^\\\d{2}\\\.\\\d{1}$'");
    }

    protected function transformData(): void
    {
        $result = DB::select('SELECT count(*) AS count FROM wilayah');
        $this->totalRows = $result[0]->count;
        $this->info("Transforming {$this->totalRows} data...");

        $result = DB::select(
            "SELECT count(*) AS count FROM wilayah w WHERE w.kode REGEXP '^\\\d{2}\\\.\\\d{2}\\\.\\\d{2}$'"
        );
        $districtChunks = floor($result[0]->count / 1000);

        $result = DB::select(
            "SELECT count(*) AS count FROM wilayah w WHERE w.kode REGEXP '^\\\d{2}\\\.\\\d{2}\\\.\\\d{2}\\\.\\\d{4}$'"
        );
        $villageChunks = floor($result[0]->count / 1000);

        $bar = $this->output->createProgressBar($districtChunks + $villageChunks + 2);

        $this->transformProvinces($bar);
        $this->transformCities($bar);
        $this->transformDistricts($bar, $districtChunks);
        $this->transformVillages($bar, $villageChunks);

        $this->newLine();
    }

    private function transformProvinces(ProgressBar $bar): void
    {
        DB::unprepared(
            <<<SQL
INSERT INTO ref_regions (`id`, `label`, `name`, `level`, `created_at`, `updated_at`)
SELECT REPLACE(`kode`, '.', '') * 100000000, `nama`, `nama`, 1, NOW(), NOW()
FROM wilayah
WHERE `kode` REGEXP '^\\\d{2}$'
ORDER BY `kode`
SQL
        );

        $bar->advance();
    }

    private function transformCities(ProgressBar $bar): void
    {
        DB::unprepared(
            <<<SQL
INSERT INTO ref_regions (`id`, `label`, `name`, `level`, `parent_id`, `created_at`, `updated_at`)
SELECT REPLACE(`kode`, '.', '') * 1000000, `nama`, `nama`, 2, REPLACE(SUBSTR(kode, 1, 2), '.', '') * 100000000,
    NOW(), NOW()
FROM wilayah
WHERE `kode` REGEXP '^\\\d{2}\\\.\\\d{2}$'
ORDER BY `kode`
SQL
        );

        $bar->advance();
    }

    private function transformDistricts(ProgressBar $bar, int $chunks): void
    {
        for ($x = 0; $x <= $chunks; $x++) {
            $offset = $x * 1000;

            DB::unprepared(
                <<<SQL
INSERT INTO ref_regions (`id`, `label`, `name`, `level`, `parent_id`, `created_at`, `updated_at`)
SELECT REPLACE(`kode`, '.', '') * 10000, `nama`, `nama`, 3, REPLACE(SUBSTR(`kode`, 1, 5), '.', '') * 1000000,
    NOW(), NOW()
FROM wilayah
WHERE `kode` REGEXP '^\\\d{2}\\\.\\\d{2}\\\.\\\d{2}$'
ORDER BY `kode`
LIMIT 1000 OFFSET {$offset}
SQL
            );

            $bar->advance();
        }
    }

    private function transformVillages(ProgressBar $bar, int $chunks): void
    {
        for ($x = 0; $x <= $chunks; $x++) {
            $offset = $x * 1000;

            DB::unprepared(
                <<<SQL
INSERT INTO ref_regions (`id`, `label`, `name`, `level`, `parent_id`, `created_at`, `updated_at`)
SELECT REPLACE(`kode`, '.', ''), `nama`, `nama`, 4, REPLACE(SUBSTR(`kode`, 1, 8), '.', '') * 10000,
    NOW(), NOW()
FROM wilayah
WHERE `kode` REGEXP '^\\\d{2}\\\.\\\d{2}\\\.\\\d{2}\\\.\\\d{4}$'
ORDER BY `kode`
LIMIT 1000 OFFSET {$offset}
SQL
            );

            $bar->advance();
        }
    }

    private function finish(): void
    {
        $missing = $this->totalRows - Region::count();

        if (! $missing) {
            DB::unprepared('DROP TABLE wilayah;');
            $this->info('Done!');
        } else {
            $this->warn("COUNTIONS! {$missing} data were missed during transformation.");
        }
    }
}
