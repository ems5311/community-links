<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * A model of a user submitted link
 *
 * Class CommunityLink
 * @package App
 */
class CommunityLink extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_id',
        'title',
        'link'
    ];

    /**
     * Creates a CommunityLink object, sets its user id.
     * Auto-approves link if we trust this user.
     *
     * @param User $user
     * @return static
     */
    public static function from(User $user)
    {
        $link = new static;

        $link->user_id = $user->id;

        if ($user->isTrusted())
        {
            $link->approve();
        }

        return $link;
    }

    /**
     * Append attributes and contribute this link
     *
     * @param $attributes
     * @return bool
     */
    public function contribute($attributes)
    {
        // Is there a submission that already has that link?
        if ($existing = $this->hasAlreadyBeenSubmitted($attributes['link']))
        {
            // Update the timestamp to the current time
            return $existing->touch();
        }


        return $this->fill($attributes)->save();
    }

    /**
     * Mark this link as approved for display
     *
     * @return $this
     */
    public function approve()
    {
        $this->approved = true;
        return $this;
    }

    /**
     * An Eloquent relation to the User model that created this link
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Eloquent relation to the channel this link belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Determine if the link has already been submitted.
     *
     * @param string $link
     * @return mixed
     */
    protected function hasAlreadyBeenSubmitted($link)
    {
        return static::where('link', $link)->first();
    }
}
