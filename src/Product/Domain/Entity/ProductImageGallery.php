<?php

namespace App\Product\Domain\Entity;

use App\Shared\Domain\ImageGallery;

class ProductImageGallery extends ImageGallery
{
    protected int $productId;

    public function __construct(
        int $id,
        array $desktopImages,
        array $mobileImages,
        array $tabletImages,
        array $thumbnailImages,
        int $productId
    ) {
        parent::__construct(
            $id,
            $desktopImages,
            $mobileImages,
            $tabletImages,
            $thumbnailImages
        );
        $this->productId = $productId;
    }
}
