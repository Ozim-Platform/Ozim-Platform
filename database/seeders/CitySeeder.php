<?php

namespace Database\Seeders;

use App\Models\City;
use App\Traits\UseAutoIncrementID;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    use UseAutoIncrementID;

    private array $cities;
    private int $regionId;

    public function __construct(array $cities, int $regionId)
    {
        $this->cities = $cities;
        $this->regionId = $regionId;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->cities as $city) {
            City::create([
                'name' => $city,
                'region_id' => $this->regionId
            ]);
        }
    }
}
