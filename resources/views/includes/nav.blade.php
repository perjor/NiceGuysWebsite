<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 ml-0 neg-p-15 w-100 d-block">
                <li class="nav-item d-inline-block">
                    <a class="nav-link {{(Request::is('/')) ? "active" : ""}}" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                @foreach($pages as $page)
                    <li class="nav-item d-inline-block">
                        <a class="nav-link {{(Request::is(str_replace(' ', '-', $page['link']))) ? "active" : ""}}" href="/{{ str_replace(' ', '-', $page['link']) }}">{{ ucfirst($page['link']) }}</a>
                    </li>
                @endforeach
                @auth
                    <li class="nav-item dropdown d-inline-block float-right">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin actions
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/admin/pages/create">Add a page</a>
                            <a class="dropdown-item" href="/admin/pages">View all pages</a>
                            <a class="dropdown-item" href="/admin/home">View all Home Blocks</a>
                            <a class="dropdown-item" href="/admin/home/create">Add a Home Block</a>
                            <a class="dropdown-item" href="/admin/upload">Upload an image</a>
                            <div class="dropdown-item">
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                            </div>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
