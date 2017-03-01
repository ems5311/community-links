<?php

namespace App\Http\Controllers;

use App\Exceptions\CommunityLinkAlreadySubmitted;
use App\Http\Requests\CommunityLinkForm;
use Illuminate\Http\Request;
use App\CommunityLink;
use App\Channel;

// Logging...
//use Log;

class CommunityLinksController extends Controller
{
    public function index()
    {
        $links = CommunityLink::where('approved', 1)
            ->latest('updated_at')
            ->paginate(3);

        $channels = Channel::orderBy('title', 'asc')->get();

        // Display all community links
        return view('community.index', compact('links', 'channels'));
    }

    public function store(CommunityLinkForm $form)
    {
        try
        {
            $form->persist();

            if (auth()->user()->isTrusted())
            {
                flash()->success('Thanks for the contribution!');
            }
            else
            {
                flash()->overlay('This contribution will be approved shortly!', 'Thanks!');
            }
        }
        catch (CommunityLinkAlreadySubmitted $e)
        {
            flash()->overlay('We\'ll instead bump the timestamps and bring that link to the top. Thanks!',
                'That link has already been submitted');
        }
        return back();
    }

    /**
     * Filters all community links by channel
     *
     * @param $channel
     */
    public function filterChannel($channel)
    {

    }
}
