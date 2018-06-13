@extends('layouts.base')
@section('title', 'Activation')

@section('body')

    <div class="row m-t-5">
        <div class="col-lg-12" style="padding: 2rem 0 1rem 0;">

            @includeWhen(isset($error), 'partials.error')
            @includeWhen(isset($success), 'partials.success')

            <p class="mx-auto">
                <a href="/login">Login</a> | <a href="/register">Signup</a>
            </p>

        </div>
    </div>

@endsection