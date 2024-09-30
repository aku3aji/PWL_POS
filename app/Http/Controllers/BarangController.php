<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    // Menampilkan halaman awal barang
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar barang',
            'list' => ['Home', 'barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang'; // Set menu yang sedang aktif

        // Ambil data barang dari model BarangModel
        $barangs = BarangModel::all();

        return view('barang.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'barangs' => $barangs // Kirim data barang ke view
        ]);
    }

    // Ambil data barang dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        // Mengambil data barang menggunakan ORM Eloquent
        $barangs = BarangModel::select('barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual');

        if ($request->barang_id) {
            $barangs->where('barang_id', $request->barang_id);
        }

        return DataTables::of($barangs)
            // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // Menambahkan kolom aksi (tombol-tombol edit, detail, hapus)
            ->addColumn('aksi', function ($barang) {
                // Tombol detail
                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // Tombol edit
                $btn .= ' <a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                // Tombol hapus (menggunakan form POST dengan metode DELETE)
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">'
                    . csrf_field()
                    . method_field('DELETE')
                    . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            // Memberitahu bahwa kolom aksi adalah HTML
            ->rawColumns(['aksi'])
            // Membuat data dalam bentuk JSON yang digunakan oleh DataTables
            ->make(true);
    }

    // Menampilkan halaman form tambah barang
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah barang',
            'list' => ['Home', 'barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah barang baru'
        ];

        $activeMenu = 'barang'; // Set menu yang sedang aktif

        return view('barang.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|string|max:10|unique:m_barangs,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kategori_id' => 'required|integer|in:1,2,3,4,5',
        ]);

        BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    // Menampilkan detail barang
    public function show(string $id)
    {
        // Mengambil data barang menggunakan ID
        $barang = BarangModel::find($id);

        // Membuat breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail barang',
            'list' => ['Home', 'barang', 'Detail']
        ];

        // Menentukan judul halaman
        $page = (object) [
            'title' => 'Detail barang'
        ];

        // Menentukan menu yang aktif
        $activeMenu = 'barang';

        // Mengarahkan ke view dengan data yang dibutuhkan
        return view('barang.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit barang
    public function edit(string $id)
    {
        // Ambil data barang berdasarkan ID
        $barang = BarangModel::find($id);

        // Membuat breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Edit barang',
            'list' => ['Home', 'barang', 'Edit']
        ];

        // Menentukan judul halaman
        $page = (object) [
            'title' => 'Edit barang'
        ];

        // Menentukan menu yang aktif
        $activeMenu = 'barang';

        // Mengarahkan ke view 'barang.edit' dengan data yang dibutuhkan
        return view('barang.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data barang
    public function update(Request $request, string $id)
    {
        // Validasi input form
        $request->validate([
            'barang_kode' => 'required|string|max:10|unique:m_barangs,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'kategori_id' => 'required|integer|in:1,2,3,4,5',
        ]);

        // Update data barang
        BarangModel::find($id)->update([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id,
        ]);

        // Redirect kembali ke halaman daftar barang dengan pesan sukses
        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    // Menghapus barang
    public function destroy(string $id)
    {
        // Mengecek apakah data barang dengan id yang dimaksud ada atau tidak
        $check = BarangModel::find($id);
        if (!$check) {
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            // Hapus data barang
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}