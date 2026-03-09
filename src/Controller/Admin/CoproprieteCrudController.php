<?php

namespace App\Controller\Admin;

use App\Entity\Copropriete;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CoproprieteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Copropriete::class;
    }

    // essai mais à supprimer
    // Dans votre CoproprieteCrudController.php
    public function configureCrud(Crud $crud): Crud
{
    return $crud
        ->setFormOptions([
            'csrf_protection' => false,
        ]);
}

        
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom de la copropriété'),
            TextField::new('refDossier', 'Référence Dossier'),
            TextField::new('adresse', 'Adresse complète'),
            DateField::new('createdAt', 'Date de création')->onlyOnIndex(),
            DateField::new('closedAt', 'Date de fin de mandat'),
            // TextareaField::new('description', 'Informations complémentaires'),
        ];
    }
    
}
