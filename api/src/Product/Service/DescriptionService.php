<?php

namespace App\Product\Service;

use App\Product\Entity\Description;
use App\Product\Repository\DescriptionRepository;

class DescriptionService
{
    protected DescriptionRepository $descriptionRepository;

    public function __construct(
        DescriptionRepository $descriptionRepository
    ) {
        $this->descriptionRepository = $descriptionRepository;
    }

    public function getById(int $id): Description
    {
        $descriptionData = $this->descriptionRepository->getById($id);
        return new Description(
            $descriptionData['id'],
            $descriptionData['description']
        );
    }
}
