<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommunityLink;
use App\Channel;

// Logging...
//use Log;

class CommunityLinksController extends Controller
{
    public function index()
    {
        $links = CommunityLink::where('approved', 1)->paginate(25);
        $channels = Channel::orderBy('title', 'asc')->get();

        // Display all community links
        return view('community.index', compact('links', 'channels'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'channel_id' => 'required|exists:channels,id',
            'title' => 'required',
            'link' => 'required|active_url|unique:community_links',
        ]);

        // Three ways to add the user ID to the $request object
//        $request->user_id = Auth::id();
//        auth()->user()->contributeLink;

        CommunityLink::from(auth()->user())
            ->contribute($request->all());

        if (auth()->user()->isTrusted())
        {
            flash()->success('Thanks for the contribution!');
        }
        else
        {
            flash()->overlay('This contribution will be approved shortly!', 'Thanks!');
        }

        return back();
    }

}
