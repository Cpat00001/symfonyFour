<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;



class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
     {
         return [
            //  IdField::new('id'),
             TextField::new('name'),
             Field::new('price'),
             TextEditorField::new('description'),
             ImageField::new('image')
             ->setBasePath('images/products')
             ->setUploadDir('public/images/products')
             ->setUploadedFileNamePattern('[randomhas].[extension]')
             ->setRequired(false),
         ];
     }
    
}
