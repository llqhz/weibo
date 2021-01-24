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
        // 加上with(user)提前一次查询,避免N+1次查询
        return $this->statuses()->with('user')->latest();
    }

    /**
     * 用户的粉丝
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        /*
        $sql = "select 
                    related.*, 
                    table.foreignPivotKey as pivot_foreignPivotKey, 
                    table.relatedPivotKey as pivot_relatedPivotKey
                from related
                inner join table on related.relatedKey = table.relatedPivotKey
                where 
                    table.foreignPivotKey = {$this->{$parentKey}}
                ";

        $sql = "select 
                    users.*,
                    followers.user_id as pivot_user_id, 
                    followers.follower_id as pivot_follower_id
                from users
                inner join followers on users.id = followers.follower_id
                where 
                    followers.user_id = 53
                ";
        */

        /*
         * $related 需要获取的关联数据
         * $table 中间表
         * $foreignPivotKey user_id 此模型在中间表的外键
         * $relatedPivotKey follower_id 关联模型在中间表的外键
         * $parentKey 此模型的主键
         * $relatedKey 关联模型的主键
         */
        // 通过foreignPivotKey来找relatedPivotKey
        return $this->belongsToMany(
            User::class,
            'followers',
            'user_id',
            'follower_id',
            'id',
            'id',
            static::class
        )->withTimestamps();
    }

    /**
     * 用户关注的人
     */
    public function followings()
    {
        /*
         * $related 需要获取的关联数据
         * $table 中间表
         * $foreignPivotKey 此模型在中间表的外键
         * $relatedPivotKey 关联模型在中间表的外键
         * $parentKey 此模型的主键
         * $relatedKey 关联模型的主键
         * on related.relatedKey = table.relatedPivotKey where foreignPivotKey=this.parentKey
         */
        // 通过foreignPivotKey来找relatedPivotKey
        return $this->belongsToMany(
            User::class,
            'followers',
            'follower_id',
            'user_id',
            'id',
            'id',
            static::class
        )->withTimestamps();
    }

    /**
     * 关注新博主
     */
    public function follow($user_ids)
    {
        return $this->followings()->sync($user_ids, false);
    }

    /**
     * 取消关注博主
     */
    public function unfollow($user_ids)
    {
        return $this->followings()->detach($user_ids);
    }

    /**
     * 是否关注过
     */
    public function isFollowing($user)
    {
        return $this->followings()->get()->contains($user);
    }

    public static function getUsersExceptMe($me)
    {
        return self::query()->where('name', '!=', $me)->get();
    }
}
