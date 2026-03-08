<?php


namespace App\Controller\Admin;

use App\Entity\Batiment;
use App\Entity\Copropriete;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem as EA_MenuItem;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

  
    public function index(): Response
    {
        $userRepo = $this->entityManager->getRepository(User::class);
        $batimentRepo = $this->entityManager->getRepository(Batiment::class);
        $coproRepo = $this->entityManager->getRepository(Copropriete::class);

        // Initialisation par défaut
        $totalCopros = 0;

        // On ne compte les copros que si l'utilisateur est syndic
        $totalCopros = null;
        if ($this->isGranted('ROLE_SYNDIC')) {
        $totalCopros = $this->entityManager->getRepository(Copropriete::class)->count([]);
    }
        return $this->render('admin/dashboard.html.twig', [
            'total_users' => $userRepo->count([]),
            'total_buildings' => $batimentRepo->count([]),
            'total_copros' => $coproRepo->count([]), // <--- On envoie la variable manquante ici
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('CoproSyndic');
    }

    public function configureMenuItems(): iterable
    {
        yield EA_MenuItem::linkToDashboard('Tableau de Bord', 'fa fa-chart-line');

        if ($this->isGranted('ROLE_SYNDIC')) {
            yield EA_MenuItem::section('Gestion Syndic');
            yield EA_MenuItem::linkToRoute('Copropriété', 'fa-file-contract', 'admin_copropriete_index');
        }

        yield EA_MenuItem::section('Gestion Immobilière');
        yield EA_MenuItem::linkToRoute('Bâtiments', 'fas fa-building', 'admin_building_index');
        yield EA_MenuItem::linkToRoute('Lots / Appartements', 'fas fa-door-open', 'admin_lot_index');
        
        yield EA_MenuItem::section('Vie de la Copropriété');
        yield EA_MenuItem::linkToRoute('Résidents', 'fas fa-users', 'admin_user_index');

        yield EA_MenuItem::section('Sécurité & Accès');
        yield EA_MenuItem::linkToRoute('Badges', 'fas fa-id-card', 'admin_badge_index');

        yield EA_MenuItem::section('Configuration');
        yield EA_MenuItem::linkToRoute('Déconnexion', 'fas fa-sign-out-alt', 'app_logout');

        // yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        // yield MenuItem::linkToCrud('Bâtiments', 'fas fa-building', Batiment::class);
    }
}