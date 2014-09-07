<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>@yield('title')</title>
        {{ HTML::style('stylesheets/app.css') }}
        {{ HTML::script('bower_components/modernizr/modernizr.js') }}
    </head>
    <body>
        <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area"> 
            <li class="name"> 
            <h1>
                <a href="/">CCSCNE Review</a>
            </h1> 
            </li> 
            <li class="toggle-topbar menu-icon">
                <a href="#"><span></span></a>
            </li> 
        </ul> 
        <section class="top-bar-section"> 
        <ul class="right"> 
            @if(Auth::check())
            <li class="has-dropdown">
                <a href="#">{{ Auth::user()->email }}</a>
                <ul class="dropdown">
                    <li>{{ link_to('/logout', 'Log out') }}</li>
                </ul>
            </li>
            @else
            <li class="has-dropdown">
                <a href="#">Account</a>
                <ul class="dropdown">
                    <li>{{ link_to('/login', 'Log in') }}</li>
                    <li>{{ link_to('/signup', 'Sign up') }}</li>
                </ul>
            </li>
             @endif
        </ul> 
        <ul class="left"> 
            <li @if(Str::startsWith(Request::path(), 'author'))
                    class="active"
                @endif>{{ link_to('/author', 'Author') }}</li>
            <li @if(Str::startsWith(Request::path(), 'reviewer'))
                    class="active"
                @endif>{{ link_to('/reviewer', 'Reviewer') }}</li>
            <li @if(Str::startsWith(Request::path(), 'chair'))
                    class="active"
                @endif>{{ link_to('/chair', 'Chair') }}</li>
        </ul> 
        </section> 
        </nav>

        <div class="row">
            <div class="large-12 columns">
                <h1>@yield('title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                @yield('content')
            </div>
        </div>

        {{ HTML::script('bower_components/jquery/dist/jquery.min.js') }}
        {{ HTML::script('bower_components/foundation/js/foundation.min.js') }}
        {{ HTML::script('js/app.js') }}
    </body>
</html>
