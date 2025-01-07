<?php

namespace App\Shared\Domain;

class Base64Image
{
    protected int $id;
    protected string $base64;
    protected string $extension; 

    public function __construct(int $id, string $base64, string $extension)
    {
        $this->id = $id;
        $this->base64 = $base64;
        $this->extension = $extension;
    }

    public function __get($property)
    {
        return $this->$property;
    }
}
