<?php

namespace App\Controller;

use App\Service\ConstantDetailManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteContactController extends AbstractController
{
    /**
     * @var ConstantDetailManager
     */
    private $manager;

    public function __construct(ConstantDetailManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/delete/contact", name="delete_contact", methods={"POST"})
     * @param Request $request
     */
    public function index(Request $request)
    {
        if($this->isCsrfTokenValid('deleteform', $request->get('__token'))) {
           $id = $request->get('id');
           $contact = $this->manager->getById($id);
           if (!empty($contact)) {
               $this->manager->delete($contact);
               $this->manager->flush();
               $this->addFlash('success', sprintf('Contact details for %s is deleted', $contact->getName()));
               return $this->redirectToRoute('contact');
           }
        }
        $this->addFlash('error', 'Something went wrong please try again later.');
        return $this->redirectToRoute('contact');
    }
}
