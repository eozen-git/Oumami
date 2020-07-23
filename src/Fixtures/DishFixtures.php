<?php


namespace App\Fixtures;

use App\Entity\Dish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class DishFixtures extends Fixture
{

    const IMAGES = [
        '0ba6e874d8322bf307b745f054f365fe.jpg',
        '068bca1c5322855ffd29b9c0b16df719.jpg',
        '76523a550575ff0bee836079d023b757.jpg',
        'b359939f7d2cf9af7f82a246215fe488.jpg',
        'f44cfb1791b749f35fa83da0852a1d46.jpg',
        'ffee4e80e32359c42972d0a8ac2cbae2.jpg',
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        foreach (self::IMAGES as $image)
        {
            $dish = new Dish();
            $dish->setName(ucfirst($faker->words(3, true)));
            $dish->setImage($image);
            $dish->setPrice($faker->randomFloat(2, 1, 5));

            $manager->persist($dish);
        }

        $manager->flush();
    }
}