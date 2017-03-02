<?php

namespace App\Http\Controllers;

use App\CommunityLink;
use App\CommunityLinkVote;
use Illuminate\Http\Request;

use App\Http\Requests;

class VotesController extends Controller
{
    /**
     * Upvote or downvote the given link
     *
     * @param CommunityLink $link
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommunityLink $link)
    {
        CommunityLinkVote::firstOrNew([
            'user_id' => auth()->id(),
            'community_link_id' => $link->id
        ])->toggle();

        return back();
    }
}
