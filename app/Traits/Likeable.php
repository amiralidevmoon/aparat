<?php

namespace App\Traits;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait Likeable
{
    public function likesCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->likes()->where('vote', 1)->count()
        );
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function dislikesCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->likes()->where('vote', -1)->count()
        );
    }

    public function likedBy(User $user)
    {
        if ($this->isLikedBy($user)) {
            $this->removeLike($user);

            return;
        }
        $this->removeDislike($user);

        return $this->addDislike($user);
    }

    public function dislikedBy(User $user)
    {
        if ($this->isDislikedBy($user)) {
            $this->removeDislike($user);

            return;
        }

        $this->removeLike($user);

        return $this->addLike($user);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()
            ->where('vote', 1)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function isDislikedBy(User $user): bool
    {
        return $this->likes()
            ->where('vote', -1)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function removeLike(User $user): void
    {
        $this->likes()
            ->where('vote', 1)
            ->where('user_id', $user->id)
            ->delete();
    }

    public function removeDislike(User $user): void
    {
        $this->likes()
            ->where('vote', -1)
            ->where('user_id', $user->id)
            ->delete();
    }

    /**
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function addLike(User $user): \Illuminate\Database\Eloquent\Model
    {
        return $this->likes()->create([
                                          'vote' => -1,
                                          'user_id' => $user->id,
                                      ]);
    }

    /**
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function addDislike(User $user): \Illuminate\Database\Eloquent\Model
    {
        return $this->likes()->create([
                                          'vote' => 1,
                                          'user_id' => $user->id,
                                      ]);
    }
}
