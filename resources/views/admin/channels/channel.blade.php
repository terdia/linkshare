@extends('layouts.base')

@section('title', 'Channels')

<?php
$success_mgs = flash('success');
if(!isset($success) && $success_mgs)
{
    $success = $success_mgs;
}
?>

@section('body')

    <div class="row m-t-5">
        <div class="col-lg-8">

            <h2 style="padding: 2rem 0 1rem 0;">Add Channel</h2>

            @includeWhen(isset($errors), 'partials.validation_errors')
            @includeWhen(isset($error), 'partials.error')
            @includeWhen(isset($success), 'partials.success')

            <form action="/admin/channel" method="post">

                <div class="form-group">
                    <label for="name"></label>
                    <input type="text" class="form-control" name="name" id="name"
                           placeholder="Channel name" value="{{ old('name') }}">
                </div>

                {{ csrf_token_field() }}

                <button type="submit" class="btn btn-primary float-right">Add Channel</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <h2 style="padding: 2rem 0 1rem 0;">Existing Channels</h2>

        @if(isset($channels) && count($channels))
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Status</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($channels as $index => $channel)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $channel->name }}</td>
                            <td>{{ $channel->slug }}</td>
                            <td> {{ !$channel->archived ? 'Active' : 'Archived' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $channels->links() }}
            @else
                <p>You have not created any channels</p>
        @endif
    </div>

@endsection