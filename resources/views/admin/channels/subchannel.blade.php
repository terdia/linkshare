@extends('layouts.base')

@section('title', 'Sub Channels')

<?php
$success_mgs = flash('success');
if(!isset($success) && $success_mgs)
{
    $success = $success_mgs;
}

$session_errors = flash('errors');
if(!isset($errors) && $session_errors)
{
    $errors = $session_errors;
}
?>

@section('body')

    <div class="row m-t-5">
        <div class="col-lg-8">

            <h2 style="padding: 2rem 0 1rem 0;">Add Subchannel</h2>

            @includeWhen(isset($errors), 'partials.validation_errors')
            @includeWhen(isset($error), 'partials.error')
            @includeWhen(isset($success), 'partials.success')

            <form action="/admin/subchannel" method="post">

                <div class="form-group">
                    <label for="name"></label>
                    <input type="text" class="form-control" name="name" id="name"
                           placeholder="Subchannel name" value="{{ old('name') }}">
                </div>

                <div class="form-group">
                    <label for="channel">Parent Channel</label>
                    @include('partials.channels')
                </div>

                {{ csrf_token_field() }}

                <button type="submit" class="btn btn-primary float-right">Add Subchannel</button>
            </form>
        </div>
    </div>

    <div class="col-lg-8">
        <h2 style="padding: 2rem 0 1rem 0;">Existing Subchannels</h2>

        @if(isset($subchannels) && count($subchannels))
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
                @foreach($subchannels as $index => $subchannel)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $subchannel->name }}</td>
                        <td>{{ $subchannel->slug }}</td>
                        <td> {{ !$subchannel->archived ? 'Active' : 'Archived' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $subchannels->links() }}
        @else
            <p>You have not created any channels</p>
        @endif
    </div>

@endsection