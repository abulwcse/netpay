<?php


namespace App\Service;


use App\Entity\Contact;
use Symfony\Component\Yaml\Yaml;

class ConstantDetailManager
{
    /**
     * @var Contact[]
     */
    private $contacts;
    /**
     * @var string
     */
    private $file;

    /**
     * ConstantDetailManager constructor.
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
        $contacts = Yaml::parseFile($file);
        $this->contacts = empty($contacts) ? [] : $this->hydrate($contacts);
    }

    /**
     * @param array $contactsArray
     * @return Contact[]
     */
    private function hydrate($contactsArray)
    {
        $contacts = [];
        foreach ($contactsArray as $key => $value) {
            $contact = new Contact();
            $contact->setId($key)
                ->setEmail($value['email'])
                ->setName($value['name'])
                ->setPhone($value['phone']);
            $contacts[$key] = $contact;
        }
        return $contacts;
    }

    /**
     * @param Contact[] $contactsArray
     * @return array
     */
    private function dehydrate($contactsArray)
    {
        $contacts = [];
        foreach ($contactsArray as $contactsArrayElement) {
            $contacts[$contactsArrayElement->getId()] = [
                'name' => $contactsArrayElement->getName(),
                'email' => $contactsArrayElement->getEmail(),
                'phone' => $contactsArrayElement->getPhone()
            ];
        }
        return $contacts;
    }

    /**
     * Update the YAML file with the latest contacts
     */
    public function flush()
    {
        $contacts = $this->dehydrate($this->contacts);
        file_put_contents($this->file, Yaml::dump($contacts));
    }

    /**
     * @param Contact $contact
     */
    public function add(Contact $contact)
    {
        $uniqueId = md5($contact->getEmail(). time());
        $contact->setId($uniqueId);
        $this->contacts[$uniqueId] = $contact;
    }

    /**
     * @param Contact $contact
     */
    public function delete(Contact $contact)
    {
        unset($this->contacts[$contact->getId()]);
    }

    /**
     * @return Contact[]|array
     */
    public function getAllContacts()
    {
        return $this->contacts;
    }

    /**
     * @param string $contacts
     */
    public function importJson(string $contacts)
    {
        $contacts = json_decode($contacts);
        foreach ($contacts as $contact) {
            $contact = (new Contact())
                ->setPhone($contact->phone)
                ->setEmail($contact->email)
                ->setName($contact->name);
            $this->add($contact);
        }
        $this->flush();
    }
}