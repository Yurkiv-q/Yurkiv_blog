<?php

namespace App\Observers;

use App\Models\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryObserver
{
    /**
     * Обробка перед створенням запису.
     */
    public function creating(BlogCategory $blogCategory)
    {
        $this->setSlug($blogCategory);
    }

    /**
     * Обробка перед оновленням запису.
     */
    public function updating(BlogCategory $blogCategory)
    {
        $this->setSlug($blogCategory);
    }

    /**
     * Генерація псевдоніма, якщо він порожній.
     */
    protected function setSlug(BlogCategory $blogCategory)
    {
        if (empty($blogCategory->slug)) {
            $blogCategory->slug = Str::slug($blogCategory->title);
        }
    }

    // Можеш залишити ці методи порожніми або реалізувати пізніше
    public function created(BlogCategory $blogCategory): void {}
    public function updated(BlogCategory $blogCategory): void {}
    public function deleted(BlogCategory $blogCategory): void {}
    public function restored(BlogCategory $blogCategory): void {}
    public function forceDeleted(BlogCategory $blogCategory): void {}
}
