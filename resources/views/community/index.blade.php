@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8">

            <h3>Community</h3>

            @include ('community.list')
        </div>

        @include ('community.add-link')
    </div>
@stop