<?php

namespace App\Product\Service;

use App\Product\Entity\Size;
use App\Product\Repository\SizeRepository;

class SizeService
{
    protected SizeRepository $sizeRepository;

    public function __construct(
        SizeRepository $sizeRepository
    ) {
        $this->sizeRepository = $sizeRepository;
    }

    public function getSizesByProductId(int $id): array
    {
        $sizesData = $this->sizeRepository->getSizesByProductId($id);
        $sizes = [];
        foreach ($sizesData as $size) {
            $size = new Size(
                $size['id'],
                $size['size']
            );
            $sizes[] = $size;
        }
        return $sizes;
    }

}
