<?php

namespace App\Ship\Parents\Seeders;

use Apiato\Core\Abstracts\Seeders\Seeder as AbstractSeeder;
use Faker\Generator;
use Illuminate\Container\Container;

abstract class Seeder extends AbstractSeeder
{
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
