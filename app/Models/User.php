<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = Hash::make($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = Hash::make($fields['password']);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    public function uploadAvatar($image)
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
        if($this->image === null) return '/img/no-avatar.png';

        return 'uploads/' . $this->image;
    }

    public function makeAdmin()
    {
        $this->is_admin = true;
        $this->save();
    }

    public function makeNormal()
    {
        $this->is_admin = false;
        $this->save();
    }

    public function toggleAdmin($value)
    {
        return $value === null ? $this->makeNormal() : $this->makeAdmin();
    }

    public function ban()
    {
        $this->is_banned = true;
        $this->save();
    }

    public function unban()
    {
        $this->is_banned = false;
        $this->save();
    }

    public function toggleBan($value)
    {
        return $value === null ? $this->unban() : $this->ban();
    }

}
