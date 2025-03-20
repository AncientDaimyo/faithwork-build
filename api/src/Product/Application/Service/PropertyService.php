<?php

namespace App\Product\Application\Service;

use App\Product\Infrastructure\Repository\PropertyRepository;
use App\Product\Domain\Property;

class PropertyService
{
    private PropertyRepository $propertyRepository;

    public function __construct(PropertyRepository $propertyRepository)
    {
        $this->propertyRepository = $propertyRepository;
    }

    public function getPropertiesByProductId(int $id): array
    {
        $propertiesData = $this->propertyRepository->getPropertiesByProductId($id);
        $properties = [];
        foreach ($propertiesData as $property) {
            $property = new Property(
                $property['id'],
                $property['name'],
                $property['value']
            );
            $properties[] = $property;
        }
        return $properties;
    }
}
