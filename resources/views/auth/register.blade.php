@extends('layouts.base')

@section('title', 'Register')

@section('recaptcha')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('body')

    <div class="row m-t-5">
        <div class="col-lg-8">

            <h2 style="padding: 2rem 0 1rem 0;">Registration Form</h2>

            @includeWhen(isset($errors), 'partials.validation_errors')
            @includeWhen(isset($error), 'partials.error')
            @includeWhen(isset($success), 'partials.success')

            <form action="/register" method="post" class="m-b-3" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                </div>

                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>

                <div class="form-group">
                    <label for="avatar">Avatar:</label>
                    <input type="file" name="avatar" class="form-control" id="avatar">
                </div>

                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="{{ config('RECAPTCHA_KEY') }}"></div>
                </div>

                {{ csrf_token_field() }}

                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </form>
        </div>
    </div>

@endsection