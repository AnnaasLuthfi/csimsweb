@extends('layouts.app')

@section('content')

<nav id="sidebar" class="sidebar bg-danger text-white vh-100 p-3">
    <button id="toggle-btn" class="btn mb-3 w-100">
        <img src="{{ asset('image/Handbag.png') }}" alt="" style="width: 15px;">
        <span class="sidebar-text text-white">SIMS Web App</span>
        <i class="fas fa-bars" style="color: white;"></i>
    </button>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link active bg-white text-dark" href="{{ route('produk.index') }}">
                <i class="fas fa-box"></i> <span>Produk</span>
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
                <p>Daftar Produk</p>

                <!-- Search and Filter Form -->
                <div class="d-flex justify-content-between align-items-center">
                    <form action="{{ route('produk.index') }}" method="GET" class="d-flex">
                        <div class="me-2">
                            <input type="text" class="form-control" name="search" placeholder="Cari barang" value="{{ request('search') }}">
                        </div>
                        <div>
                            <select name="category_id" class="form-control" onchange="this.form.submit()">
                                <option value="">Semua</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                    <div>
                        <a href="{{ route('produk.export') }}" class="btn btn-md btn-success mb-3" style="font-size: 12px;">
                            <img src="{{ asset('image/MicrosoftExcelLogo.png') }}"> Export Excel
                        </a>
                        <a href="{{ route('produk.create') }}" class="btn btn-md btn-danger mb-3" style="font-size: 12px;">
                            <img src="{{ asset('image/PlusCircle.png') }}"> Tambah Produk
                        </a>
                    </div>
                </div>

                <!-- Product Table -->
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Image</th>
                            <th>Nama Produk</th>
                            <th>Kategori Produk</th>
                            <th>Harga Beli (Rp)</th>
                            <th>Harga Jual (Rp)</th>
                            <th>Stok Produk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produks as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">
                                <img src="{{ Storage::url('public/posts/').$produk->image }}" class="rounded" style="width: 40px">
                            </td>
                            <td>{{ $produk->produk }}</td>
                            <td>{{ $produk->category->name }}</td>
                            <td>{{ $produk->hrg_beli }}</td>
                            <td>{{ $produk->hrg_jual }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td>
                                <a href="{{ route('produk.edit', $produk->id) }}"><img src="{{ asset('image/edit.png') }}" alt="" style="width: 15px;"></a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background: none; cursor: pointer;">
                                        <img src="{{ asset('image/delete.png') }}" alt="" style="width: 15px;">
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-danger">Data produk belum tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $produks->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $produks->previousPageUrl() }}">Previous</a>
                        </li>

                        @foreach ($produks->getUrlRange(1, $produks->lastPage()) as $page => $url)
                        <li class="page-item {{ $produks->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                        @endforeach

                        <li class="page-item {{ $produks->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $produks->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>

@endsection
