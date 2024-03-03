<?php

namespace WuriN7i\IdData\Database\Seeders;

use Illuminate\Database\Seeder;
use WuriN7i\IdData\Enums\RegionLevel;
use WuriN7i\IdData\Models\Region;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $this->seedProvinces();
        $this->seedCities();
        $this->seedDistricts();
    }

    protected function seedProvinces()
    {
        $path = $this->filePath('provinces.csv');

        $this->handleCvsFile($path, function ($data) {
            $attrs = [
                'bps_code' => $data[0],
                'label' => $data[1],
                'name' => $data[1],
                'level' => RegionLevel::Province,
            ];

            Region::create($attrs);
        });
    }

    protected function seedCities()
    {
        $groups = [];
        $path = $this->filePath('cities.csv');

        $this->handleCvsFile($path, function ($data) use (&$groups) {
            $parentCode = $data[1];

            if (! isset($groups[$parentCode])) {
                $groups[$parentCode] = [];
            }

            $attrs = [
                'bps_code' => $data[0],
                'name' => $data[2],
                'level' => RegionLevel::City,
            ];

            array_push($groups[$parentCode], new Region($attrs));
        });

        foreach ($groups as $parentCode => $children) {
            $province = Region::byBpsCode($parentCode)->first();

            $labeledChildren = collect($children)->map(function ($city) use ($province) {
                $city->label = "{$city->name}, {$province->label}";
                return $city;
            });

            $province->children()->addMany($labeledChildren);
        }
    }

    protected function seedDistricts()
    {
        $groups = [];
        $path = $this->filePath('districts.csv');

        $this->handleCvsFile($path, function ($data) use (&$groups) {
            $parentCode = $data[1];

            if (! isset($groups[$parentCode])) {
                $groups[$parentCode] = [];
            }

            $attrs = [
                'bps_code' => $data[0],
                'name' => $data[2],
                'level' => Regionlevel::District,
            ];

            array_push($groups[$parentCode], new Region($attrs));
        });

        foreach ($groups as $parentCode => $children) {
            $city = Region::byBpsCode($parentCode)->first();

            $labeledChildren = collect($children)->map(function ($district) use ($city) {
                $district->label = "{$district->name}, {$city->label}";
                return $district;
            });

            $city->children()->addMany($labeledChildren);
        }
    }

    protected function filePath(string $fileName): string
    {
        return __DIR__ . '/csv/' . $fileName;
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