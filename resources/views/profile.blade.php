@extends('layouts.app')

@section('content')
<nav id="sidebar" class="sidebar bg-danger text-white vh-100 p-3">
    <button id="toggle-btn" class="btn mb-3 w-100">
        <img src="{{asset('image/Handbag.png')}}" alt="" style="width: 15px;">
        <span class="sidebar-text text-white">SIMS Web App</span>
        <i class="fas fa-bars" style="color: white;"></i>
    </button>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('produk.index') }}">
                <i class="fas fa-box"></i> <span>Produk</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active bg-white text-dark" href="#">
                <i class="fas fa-user"></i> <span>Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('logout') }}">
                <i class="fas fa-arrow-right-from-bracket"></i> <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>

<main id="main-content" class="content">
    <div class="container-fluid">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="profile">
                <img src="{{asset('image/PasFoto.jpg')}}" class="rounded-circle img-fluid" style="width: 150px; height: 150px;" />
                <h4>Annaas Luthfi Alfadhli</h4><br>
                <form class="row g-3 needs-validation" novalidate>
                    <div class="col-md-8">
                        <label class="form-label">Nama Kandidat</label>
                        <span class="input-group-text" id="basic-addon1">@   Annaas Luthfi Alfadhli</span>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Posisi Kandidat</label>
                        <span class="input-group-text" id="basic-addon1">&lt;/&gt;  Web Developer</span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
