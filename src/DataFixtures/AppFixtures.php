<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Copropriete;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // On initialise Faker en Français

        // 1. Création d'un utilisateur "Syndic"
            $syndic = new User();
            $syndic->setNom($faker->name);
            $syndic->setEmail('syndic@copro.fr');
            $syndic->setRoles(['ROLE_SYNDIC']);
            $syndic->setType('Syndic');
            $syndic->setStatus('Actif');
            $syndic->setPassword($this->hasher->hashPassword($syndic, 'password123'));
            $manager->persist($syndic);

        // Créer un utilisateur "Président" aléatoire
            $president = new User();
            $president->setNom($faker->name);;
            $president->setEmail($faker->email);
            $president->setRoles(['ROLE_PRESIDENT']);
            $president->setType('Président');
            $president->setStatus($faker->randomElement(['locataire', 'proprietaire']));
            $president->setPassword($this->hasher->hashPassword($president, 'password'));
            $manager->persist($president);

        // 2. Création de 10 Copropriétés avec Faker
        for ($i = 0; $i < 10; $i++) {
            $copro = new Copropriete();

            // Générer une référence unique pour le dossier
            // Par exemple : COPRO-2026-001, COPRO-2026-002...
            $copro->setRefDossier('REF-' . strtoupper($faker->bothify('??-####')));

            $copro->setNom("Copropriété " . $faker->company); // Nom aléatoire type entreprise
            $copro->setAdresse($faker->address); // Adresse aléatoire française
            $manager->persist($copro);
        }

            $manager->flush();
    }
}