<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="{{ url('/') }}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/deposit') }}">Deposit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/draft') }}">Draft</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/transfer') }}">Transfer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/report') }}">Account statement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/backup') }}">Backup/Restore your data</a>
            </li>
        </ul>
    </div>
</nav>
