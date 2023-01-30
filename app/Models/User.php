<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);

        $this->save();
    }

    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }

    public function generatePassword($password)
    {
        if ($password === null) return;

        $this->password = Hash::make($password);
        $this->save();
    }

    public function uploadAvatar($avatar)
    {
        if ($avatar === null) return;

        $this->removeAvatar();

        $filename = $avatar->store('/', 'avatars');
        $this->avatar = $filename;

        $this->save();
    }

    public function getImage()
    {
        return $this->avatar
        ? Storage::disk('avatars')->url($this->avatar)
        : 'https://www.gravatar.com/avatar/'.md5(strtolower(trim($this->email)));
    }

    public function removeAvatar()
    {
        if ($this->avatar !== null) {
            Storage::disk('avatars')->delete($this->avatar);
        }
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
