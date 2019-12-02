<?php


namespace App\Controller\Admin;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CategoryController
 * @package App\Controller\Admin
 * @Route("/categorie")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/")
     *
     * l'url de la page est /admin/categorie (cf config/routes/annotations.yaml)
     * le nom de la route est app_admin_category_index
     * @param CategoryRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CategoryRepository $repository)
    {
        // $categories = $repository->findAll();
        // équivalent d'un findAll() avec un tri sur l'id
        $categories = $repository->findBy([], ['id' => 'ASC']);

        return $this->render("admin/category/index.html.twig",
            [
                'categories' => $categories
            ]);
    }
}