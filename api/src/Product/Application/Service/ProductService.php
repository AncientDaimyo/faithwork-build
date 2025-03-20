<?php

namespace App\Product\Application\Service;

use App\Product\Application\Boundary\ProductServiceBoundary;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Product\Domain\Product;
use Doctrine\DBAL\Types\DecimalType;

class ProductService implements ProductServiceBoundary
{
    protected ProductRepository $productRepository;
    protected CategoryService $categoryService;
    protected SizeService $sizeService;
    protected PropertyService $propertyService;
    protected DescriptionService $descriptionService;

    public function __construct(
        ProductRepository $productRepository,
        CategoryService $categoryService,
        SizeService $sizeService,
        PropertyService $propertyService,
        DescriptionService $descriptionService
    ) {
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
        $this->sizeService = $sizeService;
        $this->propertyService = $propertyService;
        $this->descriptionService = $descriptionService;
    }


    public function getProducts(): array
    {
        $productsData = $this->productRepository->getAll();
        $products = [];
        foreach ($productsData as $productData) {
            $product = $this->buildProduct($productData);
            $products[] = $product->jsonSerialize();
        }
        return $products;
    }    

    public function getProduct(int $id): array
    {
        $productData = $this->productRepository->getById($id);
        return $this->buildProduct($productData)->jsonSerialize();
    }

    protected function buildProduct(array $data): Product
    {
        if (!$this->validate($data)) {
            throw new \InvalidArgumentException('Invalid data');
        }

        $product = new Product(
            $data['id'],
            $data['name'],
            $data['price']
        );

        $sizes = $this->sizeService->getSizesByProductId($data['id']);
        $properties = $this->propertyService->getPropertiesByProductId($data['id']);
        $description = $this->descriptionService->getById($data['description_id']);
        $category = $this->categoryService->getCategoryById($data['category_id']);

        $product->setCategory($category);
        $product->setSizes($sizes);
        $product->setProperties($properties);
        $product->setDescription($description);

        return $product;
    }

    protected function validate(array $data): bool
    {
        // TODO implement validate
        return true;
    }

    public function createProduct(array $data): int
    {
        // TODO implement create product
        return 0;
    }

    public function updateProduct(int $id, array $data): int
    {
        // TODO implement update product
        return 0;
    }

    public function deleteProduct(int $id): int
    {
        // TODO implement delete product
        return 0;
    }
}
