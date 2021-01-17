<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string 数据库表名
     */
    protected $table = 'users';

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/{$hash}?s={$size}";
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            // 补充激活token
            $user->activation_token = Str::random(10);
        });
    }

    // 关联模型

    // 用户的所有文章
    public function statuses()
    {
        return $this->hasMany(Status::class, 'user_id', 'id');
    }

    public static function getUsersWithMe($me, $limit)
    {
        $one_query = self::query()->where('name', '=', $me);
        $second_query = self::query()->where('name', '!=', $me);
        return self::query()->from($one_query->union($second_query), 'u')
            ->latest()->limit($limit)->get();
    }

    /**
     * 获取用户已经发布的微博
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feed()
    {
        return $this->statuses()->latest();
    }
}
