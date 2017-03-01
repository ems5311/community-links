<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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
     * Tells if this user is trusted to submit links
     *
     * @return bool
     */
    public function isTrusted()
    {
        // Explicitly cast to boolean
        return !! $this->trusted;
    }

    public function voteFor(CommunityLink $link)
    {
        $link->votes()->create(['user_id' => $this->id]);
    }

    /**
     * Tells if the given link has been voted on by this User
     *
     * @param CommunityLink $link
     * @return bool
     */
    public function votedFor(CommunityLink $link)
    {
        return $link->votes->contains('user_id', $this->id);
    }
}
