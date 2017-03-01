<?php
/**
 * Created by PhpStorm.
 * User: stoicism
 * Date: 3/1/17
 * Time: 1:24 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class CommunityLinkVote extends Model
{
    protected $table = 'community_links_votes';

    protected $fillable = ['user_id', 'community_link_id'];

}