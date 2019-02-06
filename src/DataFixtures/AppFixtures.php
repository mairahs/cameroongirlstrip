<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Trip;
use App\Entity\Image;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        
        $categories = ['voiture', 'bus'];

        for($i=1; $i<=10; $i++)
       {
                for($u=1; $u<5; $u++)
            {
                $category = new Category; 
                $category->setName($faker->randomElement($categories));             
            }

           $trip = new Trip;
           $trip->setDeparture($faker->city)
                ->setArrival($faker->city)
                ->setDepartureDate($faker->dateTimeBetween('now', '+1 years', 'Africa/Lagos'))
                ->setReturnDate($faker->dateTimeBetween('now', '+2 years', 'Africa/Lagos'))
                ->setDescription($faker->paragraph(10, true))
                ->setNumberPersons(mt_rand(2,5))
                ->setCoverImage($faker->imageUrl(500, 400))
                ->setCreatedAt($faker->datetime('now'))
                ->setCategory($category);
            
            $manager->persist($trip);

       }

       for($j=1; $j <= 10; $j++)
       {
            $ad = new Ad;
            $ad->setTitle($faker->sentence(3))
        	   ->setPrice(mt_rand(40,200))
               ->setIntroduction($faker->paragraph(2))
               ->setLocation($faker->city)
        	   ->setContent("<p>".join('</p><p>', $faker->paragraphs(5))."</p>")
        	   ->setCoverImage($faker->imageUrl(1000,350))
               ->setRooms(mt_rand(2,5));
            
            for($l=1; $l<= mt_rand(2,5); $l++)
            {
                $image = new Image;
                $image->setUrl($faker->imageUrl(600,500))
                      ->setLegend($faker->sentence())
                      ->setAd($ad);

                $manager->persist($image);         
            }        
            $manager->persist($ad);          
       }
        $manager->flush();
    }
}
