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
        <header>
        <noscript>
            <div class="alert-box alert">
                This site relies on JavaScript, and it appears your browser has
                JavaScript disabled. Please enable JavaScript before continuing.
            </div>
        </noscript>
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
            <li class="has->form">
                {{ link_to('https://github.com/StoneyJackson/review/issues/new',
                    'Report problem', array('class'=>'button alert')) }}
            </li>
            @if(Auth::check())
            <li class="has-dropdown">
                <a href="#">{{ Auth::user()->email }}</a>
                <ul class="dropdown">
                    <li>{{ link_to_route('logout', 'Log out') }}</li>
                </ul>
            </li>
            @else
            <li class="has-dropdown">
                <a href="#">Account</a>
                <ul class="dropdown">
                    <li>{{ link_to_route('login', 'Log in') }}</li>
                    <li>{{ link_to_route('signup', 'Sign up') }}</li>
                </ul>
            </li>
             @endif
        </ul> 
        <ul class="left"> 
            @if(Auth::check())
                <li @if(Str::startsWith(Request::path(), 'author'))
                        class="active"
                    @endif>{{ link_to('/author', 'Author') }}</li>
                <li @if(Str::startsWith(Request::path(), 'reviewer'))
                        class="active"
                    @endif>{{ link_to('/reviewer', 'Reviewer') }}</li>
                @if(Auth::user()->is_a_chair())
                <li @if(Str::startsWith(Request::path(), 'chair'))
                        class="active"
                    @endif>{{ link_to('/chair', 'Chair') }}</li>
                @endif
            @endif
        </ul> 
        </section> 
        </nav>

        {{ Breadcrumbs::render() }}
        </header>

        <main>
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
        </main>


        <footer>
        <div class="columns">
            &copy; 2014 "Stoney" Herman L. Jackson II
        </div>
        </footer>

        {{ HTML::script('bower_components/jquery/dist/jquery.min.js') }}
        {{ HTML::script('bower_components/foundation/js/foundation.min.js') }}
        {{ HTML::script('js/app.js') }}
    </body>
</html>
