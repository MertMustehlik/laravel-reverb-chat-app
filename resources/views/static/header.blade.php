<nav class="navbar navbar-expand-lg bg-body-secondary">
    <div class="container">
        <a class="navbar-brand" href="{{route('conversations.index')}}">Chat App</a>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link {{Route::is('conversations.index') ? 'active' : ''}}" aria-current="page" href="{{route('conversations.index')}}">Conversations</a>
            </div>
            <div class="navbar-nav ms-auto">
                <form action="{{route("auth.logout-post")}}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
