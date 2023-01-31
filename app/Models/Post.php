<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'content', 'date'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'posts_tags',
            'post_id',
            'tag_id'
        );
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = 1;
        $post->save();

        return $post;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    public function uploadImage($image)
    {
        if ($image === null) return;

        $this->removeImage();

        $filename = $image->store('/', 'images');
        $this->image = $filename;

        $this->save();
    }

    public function removeImage()
    {
        if ($this->image !== null) {
            Storage::disk('images')->delete($this->image);
        }
    }

    public function getImage()
    {
        return $this->image
        ? Storage::disk('images')->url($this->image)
        : 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($this->email)));
    }

    public function setCategory($id)
    {
       if ($id === null) return;

       $this->category_id = $id;
       $this->save();
    }

    public function setTags($ids)
    {
        if ($ids === null) return;

        $this->tags()->sync($ids);
    }

    public function setDraft()
    {
        $this->is_published = false;
        $this->save();
    }

    public function setPublic()
    {
        $this->is_published = true;
        $this->save();
    }

    public function togglePublished($value)
    {
        return $value === null ? $this->setDraft() : $this->setPublic();
    }

    public function setFeatured()
    {
        $this->is_featured = true;
        $this->save();
    }

    public function setStandart()
    {
        $this->is_featured = false;
        $this->save();
    }

    public function toggleFeatured($value)
    {
        return $value === null ? $this->setStandart() : $this->setFeatured();
    }

    public function getCategoryTitle()
    {
        return $this->category->title ?? 'Без категории';
    }

    public function getTags()
    {
        return $this->tags->isEmpty()
        ? 'Нет тегов'
        :  implode(', ', $this->tags->pluck('title')->all());
    }


    /**
     * Interact with the post's date.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y'),
            set: fn ($value) => Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d'),
        );
    }
}
