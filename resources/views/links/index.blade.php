@extends('layouts.base')
@section('title', 'Share a link')

@section('body')

    <div class="row m-t-5">
        <div class="col-lg-12" style="padding: 2rem 0 1rem 0;">

            @includeWhen(isset($error), 'partials.error')
            @includeWhen(isset($success), 'partials.success')

            <p class="mx-auto">
                Username: {{ user()->username }} <br />
                Avatar: <br />
                <img src="{{ user()->avatar }}" alt="{{ user()->username }}">
            </p>

        </div>
    </div>

@endsection