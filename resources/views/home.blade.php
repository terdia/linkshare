@extends('layouts.base')
@section('title', 'Homepage')

@section('body')
    <div class="text-center">
        <h1>{{ getenv('APP_NAME') }}</h1>

        <p>Submit that Link and help others find the best courses and Tutorials</p>
    </div>
@endsection

