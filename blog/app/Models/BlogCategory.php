<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;
    use HasFactory;

    const ROOT = 1;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    /**
     * Батьківська категорія
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        // категорія належить іншій категорії (батьківській)
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
     * Аксесор для назви батьківської категорії
     *
     * @return string
     */
    public function getParentTitleAttribute()
    {
        $title = $this->parentCategory->title
            ?? ($this->isRoot() ? 'Корінь' : '???');

        return $title;
    }

    /**
     * Перевірка, чи є категорія кореневою
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->id === self::ROOT;
    }
}
