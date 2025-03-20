<?php

namespace App\Test\Unit\Product\Application;

use PHPUnit\Framework\TestCase;
use App\Product\Application\Service\CategoryService;
use App\Product\Infrastructure\Repository\CategoryRepository;
use PHPUnit\Framework\MockObject\MockObject;

class CategoryServiceTest extends TestCase
{
    private CategoryService $service;
    private CategoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        /**
         * @var CategoryRepository & MockObject
         */
        $this->repository = $this->createMock(CategoryRepository::class);
        $this->repository->expects($this->any())->method('getById')->willReturnCallback(function ($id) {
            switch ($id) {
                case 1:
                    return [
                        'id' => 1,
                        'name' => 'Category 1',
                        'parent_id' => 2
                    ];
                case 2:
                    return [
                        'id' => 2,
                        'name' => 'Category 2',
                        'parent_id' => 3
                    ];
                case 3:
                    return [
                        'id' => 3,
                        'name' => 'Category 3',
                        'parent_id' => null
                    ];
                default:
                    return [
                        'id' => null,
                        'name' => null,
                        'parent_id' => null
                    ];
            }
        });

        $this->repository->expects($this->any())->method('getAttributesMapping')->willReturnCallback(function () {
            return [
                'id' => 'id',
                'name' => 'name',
                'parent_id' => 'parent_id'
            ];
        });

        $this->service = new CategoryService($this->repository);
    }

    public function testGetCategoryByIdWithParents(): void
    {
        $expectation = [
            'id' => 1,
            'name' => 'Category 1',
            'parent' => [
                'id' => 2,
                'name' => 'Category 2',
                'parent' => [
                    'id' => 3,
                    'name' => 'Category 3'
                ]
            ]
        ];
        
        $this->assertEquals($expectation, $this->service->getCategoryById(1));
    }
}
