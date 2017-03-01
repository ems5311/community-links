<?php

namespace App\Http\Controllers;

use App\Exceptions\CommunityLinkAlreadySubmitted;
use App\Http\Requests\CommunityLinkForm;
use Illuminate\Http\Request;
use App\CommunityLink;
use App\Channel;

class CommunityLinksController extends Controller
{
    /**
     * Display the main page of links and the form
     *
     * @param Channel|null $channel
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Channel $channel = null)
    {
        $links = CommunityLink::with('votes')
            ->forChannel($channel)
            ->where('approved', 1)
            ->latest('updated_at')
            ->paginate(15);

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
//    public function filterChannel($channel)
//    {
//        $channelId = Channel::where('slug', $channel)->get()->id;
//        return $this->index($channelId);
//    }
}
