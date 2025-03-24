<?php

namespace App\Product\Service;

use App\Product\Repository\PropertyRepository;
use App\Product\Entity\Property;

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
