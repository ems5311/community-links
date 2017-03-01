<ul class="list-group">
    @if (count($links))
        @foreach ($links as $link)
            <li class="list-group-item">
                @if (Auth::check() && Auth::user()->votedFor($link))
                    +1
                @endif

                {{-- This span should be clickable --}}
                {{--<a href="http://"></a>--}}
                <a href="/community/{{ $link->channel->slug }}"
                class="label label-default"
                style="background: {{ $link->channel->color }}">
                    {{ $link->channel->title }}
                </a>

                <a href="{{ $link->link }}">
                    {{ $link->title }}
                </a>

                <small>
                    Contributed By <a href="#   ">{{ $link->creator->name }}</a>
                    {{ $link->updated_at->diffForHumans() }}
                </small>
            </li>
        @endforeach
    @else
        <li>
            No contributions here yet.
        </li>
    @endif
</ul>

{{ $links->links() }}
