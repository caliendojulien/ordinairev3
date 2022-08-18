<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id'),
            Field::new('grade'),
            Field::new('name'),
            Field::new('firstName'),
            ChoiceField::new('roles')->setChoices([
                'stagiaire' => 'ROLE_STAGIAIRE',
                'chef de section' => 'ROLE_CDS',
                'ordinaire' => 'ROLE_ORDINAIRE'
            ])->allowMultipleChoices()->renderExpanded()
        ];
    }

}
