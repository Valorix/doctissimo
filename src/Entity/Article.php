<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class Article {
    /**
     * @var int
     */
    public $id = null;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @var string
     * @Assert\NotBlank
     */
    private $description;

    public function __construct(string $title = null, string $description = null)
    {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Article
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}