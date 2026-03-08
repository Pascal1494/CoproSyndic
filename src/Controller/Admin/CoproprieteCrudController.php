<?php

namespace App\Controller\Admin;

use App\Entity\Copropriete;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CoproprieteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Copropriete::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom', 'Nom de la copropriété'),
            TextField::new('adresse', 'Adresse complète'),
            DateField::new('dateCreation', 'Date de création'),
            TextareaField::new('description', 'Informations complémentaires'),
        ];
    }
    
}
