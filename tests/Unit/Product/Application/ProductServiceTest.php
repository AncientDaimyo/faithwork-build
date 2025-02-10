<?php

namespace App\Test\Unit\Product\Application;

use PHPUnit\Framework\TestCase;
use App\Product\Application\Service\ProductService;
use App\Product\Infrastructure\Repository\ProductRepository;
use App\Product\Infrastructure\Repository\CategoryRepository;
use App\Product\Application\Service\CategoryService;
use App\Product\Infrastructure\Repository\DescriptionRepository;
use App\Product\Infrastructure\Repository\SizeRepository;
use App\Product\Infrastructure\Repository\PropertyRepository;

class ProductServiceTest extends TestCase
{
    protected $getProductsExpectation = [
        [
            'id' => 1,
            'name' => 'Product 1',
            'description' => [
                'id' => 1,
                'description' => 'Description 1'
            ],
            'price' => 100,
            'sizes' => [
                [
                    'id' => 1,
                    'size' => 'Size 1'
                ],
                [
                    'id' => 2,
                    'size' => 'Size 2'
                ]
            ],
            'category' => [
                'id' => 1,
                'name' => 'Category 1',
                'parent' => [
                    'id' => 1,
                    'name' => 'Parent 1'
                ]
            ],
            'properties' => [
                [
                    'id' => 1,
                    'name' => 'Property 1',
                    'value' => 'Value 1'
                ],
                [
                    'id' => 2,
                    'name' => 'Property 2',
                    'value' => 'Value 2'
                ]
            ]
        ]
    ];

    protected $productService;

    public function setUp(): void
    {
        parent::setUp();

        /**
         * @var ProductRepository & MockObject
         */
        $productRepository = $this->createMock(ProductRepository::class);

        /**
         * @var CategoryRepository & MockObject
         */
        $categoryRepository = $this->createMock(CategoryRepository::class);

        $categoryService = new CategoryService($categoryRepository);

        $this->productService = new ProductService($productRepository, $categoryService);
    }

    public function testTrue(): void
    {
        $this->assertTrue(true);
    }

    public function testGetProducts(): void
    {
        $this->assertEquals($this->getProductsExpectation, $this->productService->getProducts());
    }

}
