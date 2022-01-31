<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    private PageRepository $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/pages/{id}', name: 'page')]
    public function __invoke(Request $request, $id): Response
    {
        $page = $this->repository->findOneById($id);

        return $this->render('page/index.html.twig', [
            'page' => $page,
        ]);
    }
}
