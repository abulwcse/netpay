<?php


namespace App\Entity;


class Contact
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /** \
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Contact
     */
    public function setId(string $id): Contact
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Contact
     */
    public function setName(string $name): Contact
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Contact
     */
    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Contact
     */
    public function setPhone(string $phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }
}