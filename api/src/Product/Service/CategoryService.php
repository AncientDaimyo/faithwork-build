<?php

namespace App\Product\Service;

use App\Product\Entity\Category;
use App\Product\Repository\CategoryRepository;

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
