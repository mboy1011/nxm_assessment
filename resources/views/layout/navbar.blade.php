@yield('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <a class="navbar-brand" href="#">NXM ASSESSMENT</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ request()->is('/') ? 'active' : ''}}">
            <a class="nav-link" href="/">Commission Report</a>
        </li>
        <li class="nav-item {{ request()->is('rank') ? 'active' : ''}}">
            <a class="nav-link" href="/rank">Rank Report</a>
        </li>
        </ul>
    </div>
</nav>