<div id="navbar">
    <nav class="navbar navbar-expand">
        <a href="/" class="navbar-brand"><img src="{{ asset('/assets/img/logoheader.png') }}" alt="Folk of Lore"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="/news">News</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('messages') }}">Inbox</a></li>
                <li class="nav-item"><a class="nav-link" href="/user/inventory">Inventory</a></li>
                <li class="nav-item"><a class="nav-link" href="/forums">Forum</a></li>
                <li class="nav-item"><a class="nav-link" href="/town">Town</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Trade Post</a></li>
            </ul>
            <div id="timehud"></div>
        </div>
    </nav>
</div>