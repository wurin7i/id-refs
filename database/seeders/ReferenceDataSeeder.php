<?php

namespace WuriN7i\IdData\Database\Seeders;

use Illuminate\Database\Seeder;
use WuriN7i\IdData\Models;

class ReferenceDataSeeder extends Seeder
{
    public function run()
    {
        $this->seedBloodTypes();
        $this->seedEducationDegrees();
        $this->seedMaritals();
        $this->seedOccupations();
        $this->seedReligions();
    }

    protected function seedBloodTypes()
    {
        $bloodTypes = [
            'A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+',  'O-'
        ];

        collect($bloodTypes)
            ->map(fn ($label, $order) => ['label' => $label, 'sort_order' => $order])
            ->push(['label' => 'Tidak Tahu', 'sort_order' => 99])
            ->mapInto(Models\BloodType::class)
            ->map(fn (Models\BloodType $item) => $item->save());
    }

    protected function seedEducationDegrees()
    {
        $degrees = [
            'Tidak / Belum Sekolah', // -1
            'Belum Tamat SD / Sederajat', // 0
            'SD / Sederajat', // 1
            'SLTP / Sederajat', // 2
            'SLTA / Sederajat', // 3
            'Diploma I / II', // 4
            'Akademi / Diploma III / Sarjana Muda', // 5
            'Diploma IV / Strata I', // 6
            'Strata II', // 7
            'Strata III', // 8
        ];

        collect($degrees)
            ->map(fn (string $label, int $order) => ['label' => $label, 'sort_order' => $order - 1])
            ->mapInto(Models\EducationDegree::class)
            ->map(fn (Models\EducationDegree $item) => $item->save());
    }

    protected function seedReligions()
    {
        $religions = [
            'Islam',
            'Kristen',
            'Katholik',
            'Hindu',
            'Budha',
            'Konghucu',
            'Kepercayaan Terhadap Tuhan YME'
        ];

        collect($religions)
            ->map(fn (string $label, int $order) => ['label' => $label, 'sort_order' => $order])
            ->mapInto(Models\Religion::class)
            ->map(fn (Models\Religion $item) => $item->save());
    }

    protected function seedMaritals()
    {
        $maritals = [
            'Belum Kawin',
            'Kawin',
            'Cerai Hidup',
            'Cerai Mati',
        ];

        collect($maritals)
            ->map(fn (string $label, int $order) => ['label' => $label, 'sort_order' => $order])
            ->mapInto(Models\Marital::class)
            ->map(fn (Models\Marital $item) => $item->save());
    }

    protected function seedOccupations()
    {
        $path = __DIR__ . '/csv/occupations.csv';
        $order = 0;

        $this->handleCvsFile($path, function ($data) use (&$order) {
            $attrs = [
                'label' => $data[1],
                'sort_order' => $order++,
            ];

            Models\Occupation::create($attrs);
        });
    }

    protected function handleCvsFile(string $path, \Closure $callback)
    {
        $handle = fopen($path, 'r');

        while (($data = fgetcsv($handle, 200, ','))) {
            $callback($data);
        }

        fclose($handle);
    }
}