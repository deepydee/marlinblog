<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }

    public function allow()
    {
        $this->is_published = true;
        $this->save();
    }

    public function disallow()
    {
        $this->is_published = false;
        $this->save();
    }

    public function togglePublish()
    {
        return $this->is_published ? $this->disallow() : $this->allow();
    }

    public function remove()
    {
        $this->delete();
    }
}
