<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/categorie")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/{id}")
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Category $category)
    {
        return $this->render(
            'category/index.html.twig',
            [
                'category' => $category,
            ]
        );
    }

    public function menu(CategoryRepository $repository)
    {
        // Cette méthode permet de pouvoir choisir les catégories qu'on voudra afficher dans la barre de navigation
        $categories = $repository->findBy([], ['name' => 'ASC']);
        return $this->render(
          'category/menu.html.twig',
          [
              'categories' => $categories
          ]
        );
    }
}
