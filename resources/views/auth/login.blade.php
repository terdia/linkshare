@extends('layouts.base')

@section('title', 'Login')
@section('recaptcha')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection

@section('body')

    <div class="row m-t-5">
        <div class="col-lg-8">

            <h2 style="padding: 2rem 0 1rem 0;">Login Form</h2>

            @includeWhen(isset($errors), 'partials.validation_errors')
            @includeWhen(isset($error), 'partials.error')
            @includeWhen(isset($success), 'partials.success')

            <form action="/login" method="post" class="m-b-3">

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username" id="username"
                           placeholder="Enter username or email">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>

                <div class="row">
                    <div class="col">
                        <div class="g-recaptcha" data-sitekey="{{ config('RECAPTCHA_KEY') }}"></div>
                    </div>

                    <div class="col">
                        <div class="form-group form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input"
                                       name="remember"> Remember me
                            </label>
                        </div>
                    </div>
                </div>

                {{ csrf_token_field() }}

                <button type="submit" class="btn btn-primary float-right">Submit</button>
            </form>
        </div>
    </div>

@endsection