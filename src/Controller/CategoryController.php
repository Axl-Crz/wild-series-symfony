<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {

        return $this->render('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository) : Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);
            $this->addFlash('success', 'La nouvelle catégorie a été créée avec succès');

            // Redirect to categories list
            return $this->redirectToRoute('category_index');
        }

        // Render the form
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/{name}', name: 'show')]
    public function show(Category $category, CategoryRepository $categoryRepository, ProgramRepository $programRepository)
    {
        if (!$category) {
            throw $this->createNotFoundException(
                "No program with name : $category found in program's table."
            );
        } else {
            $programs = $programRepository->findBy(['category' => $category->getId()]);
            return $this->render('category/show.html.twig', [
                'category' => $category,
                'programs' => $programs,
                'categories' => $categoryRepository->findAll(),
            ]);
        }
    }
}