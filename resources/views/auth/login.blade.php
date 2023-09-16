@extends('layouts.app')

@section('content')
<div class="container">
    <div class="box">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <h1 class="title">{{ __('Login') }}</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="field">
                            <label class="label">{{ __('E-Mail Address') }}</label>
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <div class="control">
                                        <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="tag is-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">{{ __('Password') }}</label>
                            <div class="field-body">
                                <div class="field is-narrow">
                                    <div class="control">
                                        <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="tag is-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember_token">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <button type="submit" class="button is-link">{{ __('Login') }}</button>

                            </div>
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection
