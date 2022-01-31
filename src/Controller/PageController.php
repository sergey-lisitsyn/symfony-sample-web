<?php

namespace App\Controller;

use App\Repository\PageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    public function __construct(
        private PageRepository $repository
    ) {}

    #[Route('/pages/{id}', name: 'page')]
    public function __invoke($id): Response
    {
        $page = $this->repository->find($id);

        if ($page === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('page/index.html.twig', [
            'page' => $page,
        ]);
    }
}
