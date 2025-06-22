<?php

namespace App\Observers;

use App\Models\BlogPost;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BlogPostObserver
{
    /**
     * Обробка перед створенням запису.
     */
    public function creating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->setHtml($blogPost);
        $this->setUser($blogPost);
    }

    /**
     * Обробка перед оновленням запису.
     */
    public function updating(BlogPost $blogPost)
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
    }

    /**
     * Якщо поле published_at порожнє і is_published == 1 — генеруємо дату.
     */
    protected function setPublishedAt(BlogPost $blogPost)
    {
        if (empty($blogPost->published_at) && $blogPost->is_published) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     * Якщо slug порожній — генеруємо з title.
     */
    protected function setSlug(BlogPost $blogPost)
    {
        if (empty($blogPost->slug)) {
            $blogPost->slug = Str::slug($blogPost->title);
        }
    }

    /**
     * Встановлюємо значення поля content_html з поля content_raw.
     */
    protected function setHtml(BlogPost $blogPost)
    {
        if ($blogPost->isDirty('content_raw')) {
            // Можна підключити Markdown парсер тут, якщо треба.
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    /**
     * Якщо user_id не вказано, то встановлюємо поточного користувача або UNKNOWN_USER.
     */
    protected function setUser(BlogPost $blogPost)
    {
        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;
    }

    // Інші стандартні методи можна залишити пустими або реалізувати за потреби
    public function created(BlogPost $blogPost): void {}
    public function updated(BlogPost $blogPost): void {}
    public function deleted(BlogPost $blogPost): void {}
    public function restored(BlogPost $blogPost): void {}
    public function forceDeleted(BlogPost $blogPost): void {}
}
