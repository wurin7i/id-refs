<?php

namespace WuriN7i\IdRefs\Database\Seeders;

use Illuminate\Database\Seeder;
use WuriN7i\IdRefs\Enums\BloodType;
use WuriN7i\IdRefs\Enums\Citizenship;
use WuriN7i\IdRefs\Enums\Gender;
use WuriN7i\IdRefs\Enums\Marital;
use WuriN7i\IdRefs\Enums\ReferenceType;
use WuriN7i\IdRefs\Enums\Religion;
use WuriN7i\IdRefs\Models;

class ReferenceDataSeeder extends Seeder
{
    public function run()
    {
        $this->seedBloodTypes();
        $this->seedCitizenship();
        $this->seedEducationDegrees();
        $this->seedGender();
        $this->seedMarital();
        $this->seedOccupations();
        $this->seedReligions();
    }

    protected function seedBloodTypes()
    {
        $order = 1;
        collect(BloodType::cases())
            ->map(function (BloodType $bloodType) use (&$order) {
                return [
                    'code' => $bloodType->value,
                    'label' => $bloodType->label(),
                    'sort_order' => $order++,
                ];
            })->mapInto(Models\BloodType::class)
            ->map(fn (Models\BloodType $item) => $item->save());
    }

    protected function seedCitizenship()
    {
        $order = 1;
        collect(Citizenship::cases())
            ->map(function (Citizenship $citizenship) use (&$order) {
                return [
                    'code' => $citizenship->value,
                    'label' => $citizenship->label(),
                    'sort_order' => $order++,
                ];
            })->mapInto(Models\Citizenship::class)
            ->map(fn (Models\Citizenship $item) => $item->save());
    }

    protected function seedEducationDegrees()
    {
        $path = __DIR__.'/csv/education_degrees.csv';
        $order = -1;
        $sequence = 1;

        $this->handleCvsFile($path, function ($data) use (&$order, &$sequence) {
            $attrs = [
                'code' => ReferenceType::EducationDegree->value.'-'.$sequence++,
                'label' => $data[1],
                'sort_order' => $order++,
            ];

            Models\EducationDegree::create($attrs);
        });
    }

    protected function seedGender()
    {
        $order = 1;
        collect(Gender::cases())
            ->map(function (Gender $r) use (&$order) {
                return [
                    'code' => $r->value,
                    'label' => $r->label(),
                    'sort_order' => $order++,
                ];
            })->mapInto(Models\Gender::class)
            ->map(fn (Models\Gender $item) => $item->save());
    }

    protected function seedReligions()
    {
        $order = 1;
        collect(Religion::cases())
            ->map(function (Religion $r) use (&$order) {
                return [
                    'code' => $r->value,
                    'label' => $r->label(),
                    'sort_order' => $order++,
                ];
            })->mapInto(Models\Religion::class)
            ->map(fn (Models\Religion $item) => $item->save());
    }

    protected function seedMarital()
    {
        $order = 1;
        collect(Marital::cases())
            ->map(function (Marital $m) use (&$order) {
                return [
                    'code' => $m->value,
                    'label' => $m->label(),
                    'sort_order' => $order++,
                ];
            })->mapInto(Models\Marital::class)
            ->map(fn (Models\Marital $item) => $item->save());
    }

    protected function seedOccupations()
    {
        $path = __DIR__.'/csv/occupations.csv';
        $order = 0;
        $sequence = 1;

        $this->handleCvsFile($path, function ($data) use (&$order, &$sequence) {
            $attrs = [
                'code' => ReferenceType::Occupation->value.'-'.$sequence++,
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
