<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        
        //create some records
        // $user = new User();
        // $product = new Product();

        // $product1 = new Product();
        // $product1->setName('dinosaurs');
        // $product1->setPrice(mt_rand(10,100));
        // $product1->setDescription('dinosuars were a huuuge and danger animals');
        // $product2 = new Product();
        // $product2->setName('monster truck');
        // $product2->setPrice(mt_rand(10,100));
        // $product2->setDescription('monster trucks are huuuge and noisy cars');

        // // $user->addBasket($product1);
        // // $user->addBasket($product2);
        // $product1->addUser($user);
        // $product2->addUser($user);

        // $manager->persist($product1);
        // $manager->persist($product2);

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
