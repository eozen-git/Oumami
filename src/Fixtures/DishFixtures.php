<?php


namespace App\Fixtures;

use App\Entity\Dish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class DishFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 4; $i++)
        {
            $dish = new Dish();
            $dish->setName(ucfirst($faker->words(3, true)));
            $dish->setImage($faker->image('assets/images', 320, 200, 'food', false));
            $dish->setPrice($faker->randomFloat(2, 1, 5));

            $manager->persist($dish);
        }

        $manager->flush();
    }
}