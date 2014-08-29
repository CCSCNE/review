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
