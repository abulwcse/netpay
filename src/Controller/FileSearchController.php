<?php

namespace App\Controller;

use App\Repository\FilesystemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FileSearchController extends AbstractController
{
    /**
     * @var FilesystemRepository
     */
    private $repository;

    public function __construct(FilesystemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/file/search", name="file_search")
     */
    public function index(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            if ($this->isCsrfTokenValid('search_form', $request->get('__token'))) {
                $results = $this->repository->getAllBySearchTerm($request->get('q'));
                return $this->render('file_search/index.html.twig', [
                    'results' => $results
                ]);
            }
            $this->addFlash('error', 'Invalid action. Please try again.');
            return $this->redirectToRoute('file_search');
        }
        return $this->render('file_search/index.html.twig');
    }
}
