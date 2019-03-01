<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\Trip;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Category;
use App\Entity\AdBooking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        $adminRole = new Role;
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser  = new User;
        $adminUser->setFirstName('Maïrah')
                  ->setLastName('Moukoury')
                  ->setEmail('mairahs16@gmail.com')
                  ->setHash($this->encoder->encodePassword($adminUser, 'passwordpassword'))
                  ->setPicture('https://randomuser.me/api/portraits/women/62.jpg')
                  ->setIntroduction($faker->sentence())
                  ->setDescription("<p>".join('</p><p>', $faker->paragraphs(1))."</p>")
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);
        
        $categories = [];
        for($k=1; $k<=3; $k++)
        {
            $category = new Category;
            $category->setName($faker->word());
            $manager->persist($category);
            $categories[] = $category;
        }

        $users = [];
        $genres = ["male", "female"];

        for($u=1; $u <= 10; $u++)
        {
            $user = new User;
            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99).'.jpg';
            $picture .= ($genre == 'male' ? 'men/' : 'women/').$pictureId;
            $user->setFirstname($faker->firstname($genre))
                 ->setLastName($faker->lastname)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription("<p>".join('</p><p>', $faker->paragraphs(3))."</p>")
                 ->setHash($this->encoder->encodePassword($user, 'password'))
                 ->setPicture($picture);
 
                 $manager->persist($user);
                 $users[] = $user;
 
        }
        
        for($i=1; $i<=10; $i++)
       {

           $trip = new Trip;
           $user = $users[mt_rand(0, count($users) - 1)];
           $category = $categories[mt_rand(0, count($categories) - 1)];
           $trip->setDeparture($faker->city)
                ->setArrival($faker->city)
                ->setDepartureDate($faker->dateTimeBetween('now', '+1 years', 'Africa/Lagos'))
                ->setReturnDate($faker->dateTimeBetween('now', '+2 years', 'Africa/Lagos'))
                ->setDescription($faker->paragraph(10, true))
                ->setNumberPersons(mt_rand(2,5))
                ->setCoverImage($faker->imageUrl(500, 400))
                ->setCreatedAt($faker->datetime('now'))
                ->setCategory($category)
                ->setTraveller($user);
            
            $manager->persist($trip);

       }

       for($j=1; $j <= 10; $j++)
       {
            $ad = new Ad;
            $user = $users[mt_rand(0, count($users) - 1)];
            $ad->setTitle($faker->sentence(3))
        	   ->setPrice(mt_rand(40,200))
               ->setIntroduction($faker->paragraph(2))
               ->setLocation($faker->city)
        	   ->setContent("<p>".join('</p><p>', $faker->paragraphs(5))."</p>")
        	   ->setCoverImage($faker->imageUrl(1000,350))
               ->setRooms(mt_rand(2,5))
               ->setAuthor($user);
            
            for($l=1; $l<= mt_rand(2,5); $l++)
            {
                $image = new Image;
                $image->setUrl($faker->imageUrl(600,500))
                      ->setLegend($faker->sentence())
                      ->setAd($ad);

                $manager->persist($image);         
            } 
            
            for($x=1; $x <= mt_rand(1,5); $x++)
            {
                $adBooking = new AdBooking();

                $createdAt = $faker->dateTimeBetween('-6months');
                $startDate = $faker->dateTimeBetween('-3months');
                $duration = mt_rand(3,10);
                $endDate = (clone $startDate)->modify('+'.$duration.'days');
                $amount = $ad->getPrice() * $duration;
                $adBooker = $users[mt_rand(0, count($users) - 1)];
                $comment= $faker->paragraph();

                $adBooking->setAdBooker($adBooker)
                          ->setAd($ad)
                          ->setCreatedAt($createdAt)
                          ->setStartDate($startDate)
                          ->setEndDate($endDate)
                          ->setAmount($amount)
                          ->setComment($comment);
                $manager->persist($adBooking);       
            }
            $manager->persist($ad);          
       }
        $manager->flush();
    }
}
