<div id="banner">
    <div class="auth-btns">
        @if(!Auth::check())
        <a href="/user/register" class="btn primary white-font">Register</a>
        <a href="/user/login" class="btn danger white-font">Login</a>
        @else
        <a href="/user/logout" class="btn danger white-font">Logout</a>
        @endif
    </div>
    <div class="main-btns">
        <button class="primary large white-font border">Shop</button>
        <button class="primary large white-font border">Explore</button>
    </div>
</div>