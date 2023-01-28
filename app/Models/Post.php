<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title', 'content'];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
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
        Storage::delete('uploads/' . $this->image);
        $this->delete();
    }

    public function uploadImage($image)
    {
        if ($image === null) return;

        Storage::delete('uploads/' . $this->image);
        $filename = Str::random(10) . '.' . $image->extension();
        $image->saveAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    public function getImage()
    {
        if($this->image === null) return '/img/no-image.png';

        return 'uploads/' . $this->image;
    }

    public function setCategoty($id)
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

    public function toggleStatus($value)
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
}
