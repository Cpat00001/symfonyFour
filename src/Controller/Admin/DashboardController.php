<?php

namespace App\Controller\Admin;

use App\Entity\Product;

use App\Controller\ProductController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
       // return parent::index();

       // redirect to some CRUD controller
       $routeBuilder = $this->get(AdminUrlGenerator::class);

       return $this->redirect($routeBuilder->setController(ProductCrudController::class)->generateUrl());

       // you can also redirect to different pages depending on the current user
    //    if ('jane' === $this->getUser()->getUsername()) {
    //        return $this->redirect('...');
    //    }

       // you can also render some template to display a proper Dashboard
       // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
       // return $this->render('product_index');
        
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SymfonyFour');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Product');
        yield MenuItem::linkToCrud('Products', 'fa fa-tags', Product::class);
        yield MenuItem::linkToRoute('List of products','fab fa-product-hunt','product_index');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
