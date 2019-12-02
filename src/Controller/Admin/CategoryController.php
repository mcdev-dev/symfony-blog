<?php


namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    /**
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\Response
     * {id} est optionnel, vaut null par défaut et doit être un nombre si renseigné.
     * @Route("/edition/{id}", defaults={"id": null}, requirements={"id": "\d+"})
     */
    public function edit(Request $request, EntityManagerInterface $manager, $id)
    {
        if (is_null($id)) { // Création
            $category = new Category();
        } else { // modification
            $category = $manager->find(Category::class, $id);
            if (is_null($category)) {
                throw new NotFoundHttpException();
            }
        }
        // Création du formulaire relié à la catégorie
        $form = $this->createForm(CategoryType::class, $category);

        // Le formulaire analyse la rêquete et fait le mapping avec l'entité s'il a été soumis
        $form->handleRequest($request);

        dump($category);

        // Si le formulaire a été soumis
        if ($form->isSubmitted()) {
            // Si les validations à partir des annotations dans l'entité Category sont OK
            if ($form->isValid()) {
                // Enregistrement de la catégorie en BDD
                $manager->persist($category);
                $manager->flush();

                if (is_null($id)) {
                    $this->addFlash('success', 'La nouvelle catégorie a été enregistrée');
                    return $this->redirectToRoute('app_admin_category_index');
                } else {
                    $this->addFlash('success', 'La catégorie a été modifiée');
                    return $this->redirectToRoute('app_admin_category_index');
                }
            } else {
                $this->addFlash('error', 'Le formulaire contient des erreurs');
            }
        }
        return $this->render(
            'admin/category/edit.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param EntityManagerInterface $manager
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/suppresion/{id}", requirements={"id": "\d+"})
     */
    public function delete(EntityManagerInterface $manager, Category $category)
    {
        // Suppression de la catégorie en BDD
        $manager->remove($category);
        $manager->flush();

        $this->addFlash('success', 'La catégorie a été supprimée');
        return $this->redirectToRoute('app_admin_category_index');

    }
}