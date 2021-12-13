<!doctype html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">
  <head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{config('app.name', 'Laravel')}} Doc - @yield('title')</title>
    <link href="{{asset('doc-assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">{{config('app.name', 'Laravel')}}
          <span class="badge rounded-pill bg-primary">Beta 1.0</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    @yield('content')

    <script src="{{asset('doc-assets/js/bootstrap.min.js')}}"
            language="javascript" />
  </body>
</html>
