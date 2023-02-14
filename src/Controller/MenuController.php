<?php

namespace App\Controller;

use App\Entity\Formula;
use App\Entity\Menu;
use App\Form\FormulaType;
use App\Form\MenuType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/carte', name: 'carte')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Menu::class);
        $menus = $repository->findAll(); // SELECT * FROM `restaurant_dishes`;

        $repositoryFormula = $doctrine->getRepository(Formula::class);
        $formulas = $repositoryFormula->findAll(); // SELECT * FROM `restaurant_menu`

        return $this->render('menu/index.html.twig', [
            "menus" => $menus,
            "formulas" => $formulas
        ]);
    }

    // URL a sécurisé
    #[Route('/carte/new')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($menu);
            $em->flush();
            return $this->redirectToRoute('carte');
        }
        return $this->render('menu/form.html.twig', [
            'menu_form' => $form->createView()
        ]);
    }

    // URL a sécurisé
    #[Route('/carte/edit/{id}', name: "edit-carte", requirements: ["id" => "\d+"])]
    public function update(Menu $menu, ManagerRegistry $doctrine, Request $request): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('carte');
        }
        return $this->render('menu/form.html.twig', [
            'menu_form' => $form->createView()
        ]);
    }

    // URL a sécurisé
    #[Route('/carte/delete/{id}', name: "delete-carte", requirements: ["id" => "\d+"])]
    public function delete(Menu $menu, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($menu);
        $em->flush();

        return $this->redirectToRoute('carte');
    }

    // URL a sécurisé
    #[Route('/menu/new')]
    public function createMenu(Request $request, ManagerRegistry $doctrine): Response
    {
        $formula = new Formula();
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $doctrine->getManager();
            $em->persist($formula);
            $em->flush();
            return $this->redirectToRoute('carte');
        }
        return $this->render('formula/form.html.twig', [
            'formula_form' => $form->createView()
        ]);
    }
}
