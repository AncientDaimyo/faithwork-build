<?php

namespace App\Shared\Domain;

abstract class ImageGallery
{
    protected int $id;

    /** @var Base64Image[] */
    protected array $desktopImages;

    /** @var Base64Image[] */
    protected array $mobileImages;

    /** @var Base64Image[] */
    protected array $tabletImages;

    /** @var Base64Image[] */
    protected array $thumbnailImages;

    public function __construct(
        int $id,
        array $desktopImages,
        array $mobileImages,
        array $tabletImages,
        array $thumbnailImages
    ) {
        $this->id = $id;
        $this->desktopImages = $desktopImages;
        $this->mobileImages = $mobileImages;
        $this->tabletImages = $tabletImages;
        $this->thumbnailImages = $thumbnailImages;
    }
}
