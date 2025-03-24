<?php

use PHPUnit\Framework\TestCase;
use App\Product\Application\Service\ProductService;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Product\Application\Service\CategoryService;
use App\Product\Application\Service\SizeService;
use App\Product\Application\Service\PropertyService;
use App\Product\Application\Service\DescriptionService;
use App\Product\Domain\Product;

class ProductServiceTest extends TestCase
{
    private $productRepository;
    private $categoryService;
    private $sizeService;
    private $propertyService;
    private $descriptionService;
    private $productService;

    protected function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->categoryService = $this->createMock(CategoryService::class);
        $this->sizeService = $this->createMock(SizeService::class);
        $this->propertyService = $this->createMock(PropertyService::class);
        $this->descriptionService = $this->createMock(DescriptionService::class);

        $this->productService = new ProductService(
            $this->productRepository,
            $this->categoryService,
            $this->sizeService,
            $this->propertyService,
            $this->descriptionService
        );
    }

    public function testGetAllProductsSuccessfully()
    {
        $productData = [
            ['id' => 1, 'name' => 'Product 1', 'price' => '10.00', 'description_id' => 1, 'category_id' => 1],
            ['id' => 2, 'name' => 'Product 2', 'price' => '20.00', 'description_id' => 2, 'category_id' => 2]
        ];

        $this->productRepository->method('getAll')->willReturn($productData);

        $this->categoryService->method('getCategoryById')->willReturn(new Category(1, 'Category 1'));
        $this->sizeService->method('getSizesByProductId')->willReturn([]);
        $this->propertyService->method('getPropertiesByProductId')->willReturn([]);
        $this->descriptionService->method('getById')->willReturn(new Description(1, 'Description 1'));

        $products = $this->productService->getProducts();

        $this->assertCount(2, $products);
    }

    public function testGetProductByIdSuccessfully()
    {
        $productData = ['id' => 1, 'name' => 'Product 1', 'price' => '10.00', 'description_id' => 1, 'category_id' => 1];

        $this->productRepository->method('getById')->willReturn($productData);

        $this->categoryService->method('getCategoryById')->willReturn(new Category(1, 'Category 1'));
        $this->sizeService->method('getSizesByProductId')->willReturn([]);
        $this->propertyService->method('getPropertiesByProductId')->willReturn([]);
        $this->descriptionService->method('getById')->willReturn(new Description(1, 'Description 1'));

        $product = $this->productService->getProduct(1);

        $this->assertEquals('Product 1', $product['name']);
    }

    public function testBuildProductWithAllEntities()
    {
        $productData = ['id' => 1, 'name' => 'Product 1', 'price' => '10.00', 'description_id' => 1, 'category_id' => 1];

        $this->categoryService->method('getCategoryById')->willReturn(new Category(1, 'Category 1'));
        $this->sizeService->method('getSizesByProductId')->willReturn([]);
        $this->propertyService->method('getPropertiesByProductId')->willReturn([]);
        $this->descriptionService->method('getById')->willReturn(new Description(1, 'Description 1'));

        $product = $this->productService->buildProduct($productData);

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testBuildProductWithInvalidData()
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidData = ['name' => 'Product 1', 'price' => '10.00'];

        $this->productService->buildProduct($invalidData);
    }

    public function testGetProductWithNonExistentId()
    {
        $this->productRepository->method('getById')->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);

        $this->productService->getProduct(999);
    }

    public function testGetAllProductsWithEmptyList()
    {
        $this->productRepository->method('getAll')->willReturn([]);

        $products = $this->productService->getProducts();

        $this->assertEmpty($products);
    }
}