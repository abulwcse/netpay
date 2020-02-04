<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Service\CommonValidator;
use App\Service\ConstantDetailManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @var ConstantDetailManager
     */
    private $manager;
    /**
     * @var CommonValidator
     */
    private $validator;

    /**
     * ContactController constructor.
     *
     * @param ConstantDetailManager $manager
     * @param CommonValidator $validator
     */
    public function __construct(ConstantDetailManager $manager, CommonValidator $validator)
    {
        $this->manager = $manager;
        $this->validator = $validator;
    }

    /**
     * @Route("/contacts", name="contact")
     */
    public function index()
    {
       $contact = new Contact();
       $contact->setName('Abul');
       $contact->setEmail('abul.cse@gmail.com');
       $contact->setPhone('07455289015');

       return $this->render('contact\index.html.twig', [
           'contacts' => $this->manager->getAllContacts()
       ]);
    }

    /**
     * @Route("/contacts/save", name="add_contact")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addContact(Request $request)
    {

        if ($request->getMethod() === 'POST' ) {
            $data = $request->get('data');
            $contacts = json_decode($data, true);
            $processed = [];
            $hasError = false;
            foreach ($contacts as $key => $contact) {
                $contact['errors'] = [];
                if (!$this->validator->isAlphabetic($contact['name']) ) {
                    $hasError = true;
                    $contact['errors']['name'] = true;
                }
                if(!$this->validator->isEmail($contact['email'])) {
                    $hasError = true;
                    $contact['errors']['email'] = true;
                }
                if(!$this->validator->isNumber($contact['phone'])) {
                    $hasError = true;
                    $contact['errors']['phone'] = true;
                }
                $processed[$key] = $contact;
            }

            if (!$hasError) {
                $this->manager->importJson($data);
                $this->addFlash('success', "Contacts have been updated.");
                return $this->redirectToRoute('contact');
            }
            return $this->render('contact\form.html.twig', [
                'data' => json_encode($processed),
            ]);
        }
        return $this->render('contact\form.html.twig');

    }
}
