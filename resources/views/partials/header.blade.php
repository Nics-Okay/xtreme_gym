<div class="index-top">
    <div class="index-top-left">
        <h1 onclick="window.location.href='{{ route('main') }}'">XTREME GYM WORLD</h1>
    </div>
    <div class="index-top-right">
        @if (Route::has('login'))
            @auth
                <div class="index-top-guest" id="sign-up">
                    <a href="{{ route('filter') }}">Sign up</a>
                </div>
                <div class="index-top-guest" id="log-in">
                    <a href="{{ route('filter') }}">Sign in</a>
                </div>
                @else
                    <div class="index-top-guest" id="sign-up">
                        <a href="{{ route('register') }}">Sign up</a>
                    </div>
                    <div class="index-top-guest" id="log-in">
                        <a href="{{ route('login') }}">Sign in</a>
                    </div>
            @endauth
        @endif
    </div>
</div>