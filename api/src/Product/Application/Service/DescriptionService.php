<?php

namespace App\Product\Application\Service;

use App\Product\Domain\Description;
use App\Product\Infrastructure\Repository\DescriptionRepository;

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
