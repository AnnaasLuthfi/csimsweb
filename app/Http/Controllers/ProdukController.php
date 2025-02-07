<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProdukController extends Controller
{

    public function export()
    {
        $products = Produk::with('category')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['ID', 'Nama Produk', 'Kategori', 'Harga Beli', 'Harga Jual', 'Stok Produk'];

        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $row, $product->id);
            $sheet->setCellValue('B' . $row, $product->produk);
            $sheet->setCellValue('C' . $row, $product->category ? $product->category->name : 'Tanpa Kategori');
            $sheet->setCellValue('D' . $row, $product->hrg_beli);
            $sheet->setCellValue('E' . $row, $product->hrg_jual);
            $sheet->setCellValue('F' . $row, $product->stok);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'produk.xlsx';

        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment;filename="produk.xlsx"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }


    public function index(Request $request)
    {
        $categories = Category::all();
        $category_id = $request->input('category_id');
        $search = $request->input('search');

        $produks = Produk::query();

        if ($category_id) {
            $produks = $produks->where('category_id', $category_id);
        }

        if ($search) {
            $produks = $produks->where('produk', 'like', '%' . $search . '%');
        }

        $produks = $produks->latest()->paginate(5);

        return view('produk.index', compact('produks', 'categories', 'category_id', 'search'));
    }




    public function create()
    {
        $categories = Category::all();
        return view('produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'produk' => 'required|min:5',
            'hrg_beli' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $hargaJual = round($request->hrg_beli * 1.3);

        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        if (Produk::where('produk', $request->produk)->exists()) {
            return redirect()->back()->with('error', 'Nama produk sudah digunakan!');
        }

        Produk::create([
            'produk' => $request->produk,
            'hrg_beli' => $request->hrg_beli,
            'hrg_jual' => $hargaJual,
            'stok' => $request->stok,
            'category_id' => $request->category_id,
            'image' => $image->hashName(),
        ]);


        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(Produk $produk)
    {
        $categories = Category::all();
        return view('produk.edit', compact('produk', 'categories'));
    }


    public function update(Request $request, Produk $produk)
    {
        $this->validate($request, [
            'produk' => 'required|min:5',
            'hrg_beli' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $hargaJual = round($request->hrg_beli * 1.3);

        if (Produk::where('produk', $request->produk)->where('id', '!=', $produk->id)->exists()) {
            return redirect()->back()->with('error', 'Nama produk sudah digunakan!');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            Storage::delete('public/posts/' . $produk->image);

            $produk->update([
                'produk' => $request->produk,
                'hrg_beli' => $request->hrg_beli,
                'hrg_jual' => $hargaJual,
                'stok' => $request->stok,
                'category_id' => $request->category_id,
                'image' => $image->hashName(),
            ]);
        } else {
            $produk->update([
                'produk' => $request->produk,
                'hrg_beli' => $request->hrg_beli,
                'hrg_jual' => $hargaJual,
                'stok' => $request->stok,
                'category_id' => $request->category_id,
            ]);
        }

        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(Produk $produk)
    {
        Storage::delete('public/posts/' . $produk->image);

        $produk->delete();

        return redirect()->route('produk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
