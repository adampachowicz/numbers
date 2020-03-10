<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Number
{
    /**
     * @var string
     *
     * @Assert\NotBlank
     */
    private $content;

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

}