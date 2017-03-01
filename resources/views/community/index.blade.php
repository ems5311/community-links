@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8">

            <a href="/community">
                <h3>Community</h3>
            </a>

            @include ('community.list')
        </div>

        @include ('community.add-link')
    </div>
@stop