<?php

namespace App\DataFixtures;

use App\Entity\Copropriete;
use App\Entity\User;
use App\Entity\Batiment;
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

    /**
     * Le point d'entrée unique de vos fixtures.
     * Il orchestre l'ordre de création (les parents avant les enfants).
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // 1. Création des données de base
        $this->loadUsers($manager, $faker);
        
        // 2. Création des Copropriétés (qui sont des "parents")
        $copros = $this->loadCoproprietes($manager, $faker);
        
        // 3. Création des Bâtiments (liés aux copropriétés)
        $this->loadBatiments($manager, $copros, $faker);

        // 4. Envoi unique en base de données
        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager, $faker): void
    {
        // Création du Syndic
        $syndic = new User();
        $syndic->setNom($faker->name);
        $syndic->setEmail('syndic@copro.fr');
        $syndic->setRoles(['ROLE_SYNDIC']);
        $syndic->setType('Syndic');
        $syndic->setStatus('Actif');
        $syndic->setPassword($this->hasher->hashPassword($syndic, 'password123'));
        $manager->persist($syndic);

        // Création d'un Président
        $president = new User();
        $president->setNom($faker->name);
        $president->setEmail($faker->email);
        $president->setRoles(['ROLE_PRESIDENT']);
        $president->setType('Président');
        $president->setStatus($faker->randomElement(['locataire', 'proprietaire']));
        $president->setPassword($this->hasher->hashPassword($president, 'password'));
        $manager->persist($president);
    }

    private function loadCoproprietes(ObjectManager $manager, $faker): array
    {
        $copros = [];
        for ($i = 0; $i < 10; $i++) {
            $copro = new Copropriete();
            $copro->setRefDossier('REF-' . strtoupper($faker->bothify('??-####')));
            // $copro->setCreatedAt($faker->dateTimeBetween('-5 years', 'now'));
            $date = $faker->dateTimeBetween('-5 years', 'now');
            $copro->setCreatedAt(\DateTimeImmutable::createFromMutable($date));
            $copro->setNom("Copropriété " . $faker->company);
            $copro->setAdresse($faker->address);
            
            $manager->persist($copro);
            $copros[] = $copro; // On stocke l'objet pour lier les bâtiments plus tard
        }
        return $copros;
    }

    private function loadBatiments(ObjectManager $manager, array $copros, $faker): void
    {
        foreach ($copros as $copro) {
            $nbBatiments = rand(1, 3);
            for ($j = 0; $j < $nbBatiments; $j++) {
                $batiment = new Batiment();
                // $batiment->setNbEtages($faker->numberBetween(4, 12));
                $etages = $faker->numberBetween(2, 6) * 2;
                $batiment->setNbEtages($etages);
                $batiment->setAAscenseur($faker->boolean());
                $batiment->setNom("Bâtiment " . chr(65 + $j)); // A, B, C...
                $batiment->setCopropriete($copro); // Relation établie ici
                $manager->persist($batiment);
            }
        }
    }
}