<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;


class UserFixtures extends Fixture
{


    public function __construct()
    {

        $this->factory = new PasswordHasherFactory([
        'common' => ['algorithm' => 'bcrypt'],
        'sodium' => ['algorithm' => "sodium"],
        ]);
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User(); //Pensez bien à ajouter le use App\Entity\User en haut du fichier !
        $user->setUsername('John');
        //$this->hashPassword->$user->setPassword('test');
        $hasher = $this->factory->getPasswordHasher('common');
        $user->setPassword($hasher->hash('test'));
        $user->setName("John Doe");
        $manager->persist($user);
        $manager->flush();
    }
}
/*
 * Hashing a Stand-Alone String
The password hasher can be used to hash strings independently of users. By using the PasswordHasherFactory,
 you can declare multiple hashers, retrieve any of them with its name and create hashes.
 You can then verify that a string matches the given hash:
 * use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;

// configure different hashers via the factory
$factory = new PasswordHasherFactory([
    'common' => ['algorithm' => 'bcrypt'],
    'sodium' => ['algorithm' => 'sodium'],
]);

// retrieve the hasher using bcrypt
$hasher = $factory->getPasswordHasher('common');
$hash = $hasher->hash('plain');

// verify that a given string matches the hash calculated above
$hasher->verify($hash, 'invalid'); // false
$hasher->verify($hash, 'plain'); // true
 */