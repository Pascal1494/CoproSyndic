<?php

// src/DataFixtures/AppFixtures.php
namespace App\DataFixtures;

use App\Entity\Copropriete;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // Pour avoir des noms français

        // 1. Création de la copropriété
        $copro = new Copropriete();
        $copro->setNom('Résidence des Fleurs');
        $copro->setRefDossier('A45698DS');
        $copro->setAdresse($faker->address);
        $copro->setCreatedAt(new \DateTimeImmutable());
        
        $manager->persist($copro); // "Prépare" l'objet pour l'enregistrement

        // Ici, vous feriez une boucle pour créer vos 10 bâtiments...
        
        $manager->flush(); // "Envoie" tout en base de données d'un seul coup
    }
}