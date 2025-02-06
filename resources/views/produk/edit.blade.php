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
            <a class="nav-link active bg-white text-dark" href="{{ route('produk.index') }}">
                <i class="fas fa-box text-white"></i> <span>Produk</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('profiles') }}">
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
            <div class="tab-pane fade show active" id="home">
                <p><a href="{{ route('produk.index') }}">Daftar Produk</a> > Edit Produk</p>
                <div class="tab-pane fade show active" id="home">
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate">
                        @csrf
                        @method('PUT')

                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Kategori</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" name="category_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="validationCustom02" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control @error('produk') is-invalid @enderror" name="produk" value="{{ old('produk', $produk->produk) }}" placeholder="Masukkan Nama Barang">

                        </div>


                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Harga Beli</label>
                            <input type="text" class="form-control @error('hrg_beli') is-invalid @enderror" name="hrg_beli" value="{{ old('hrg_beli', $produk->hrg_beli) }}" placeholder="Masukkan Judul Post">

                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label">Harga Jual</label>
                            <input type="text" class="form-control @error('hrg_jual') is-invalid @enderror" name="hrg_jual" value="{{ old('hrg_jual', $produk->hrg_jual) }}" placeholder="Masukkan Judul Post">

                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label">Stock Barang</label>
                            <input type="text" class="form-control @error('stok') is-invalid @enderror" name="stok" value="{{ old('stok', $produk->stok) }}" placeholder="Masukkan jumlah stock barang">
                        </div>

                        <div class="form-group">
                            <input type="file" class="form-control" name="image">
                        </div>

                        <div class="col-auto ms-auto">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-outline-primary">Batalkan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
