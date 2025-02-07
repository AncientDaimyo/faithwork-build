<?php

namespace App\Product\Application\Service;

use App\Product\Domain\Category;
use App\Product\Infrastructure\Repository\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoryById(int $id): Category
    {
        $category = $this->categoryRepository->getById($id);

        if (!empty($category['parent_id'])) {
            $category['parent'] = $this->getCategoryById($category['parent_id']);
        }

        unset($category['parent_id']);

        return new Category(
            $category['id'],
            $category['name'],
            $category['parent'] ?? null
        );
    }
}
