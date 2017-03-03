<?php

namespace App\Http\Controllers;

use App\CommunityLink;
use App\CommunityLinkVote;
use Illuminate\Http\Request;

use App\Http\Requests;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Upvote or downvote the given link
     *
     * @param CommunityLink $link
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CommunityLink $link)
    {
        auth()->user()->toggleVoteFor($link);
        return back();
    }
}
