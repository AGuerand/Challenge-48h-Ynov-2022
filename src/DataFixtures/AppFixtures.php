<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\User;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
       
        $faker = \Faker\Factory::create('fr_FR');
        $user = new User;   
        $date = "01-09-2015 05:45";
            $user ->setUsername('bitchass')
                ->setPassword('Damnson')
                ->setEmail('nova77230@gmail.com');
                $manager->persist($user);
            $manager->flush();
            
        for($i = 1; $i <= mt_rand(8, 10); $i++)
        {
            $product = new Evenement;
            

            
            $product->setNom($faker->sentence(3))
                ->setUserId($user)
                // ->setImage($faker->imageUrl)
                // ->setPrix($faker->randomFloat(2, 10, 100))
                ->setImage($faker->imageUrl)
                ->setAttendant(2568)
                ->setContenu($faker->sentence(5))
                // ->setDate(new \DateTime());
                ->setDate(\DateTime::createFromFormat('d-m-Y H:i',$date));
            $manager->persist($product);
        }
        $manager->flush();
    }
}
