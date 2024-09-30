<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class kategoriController extends Controller
{
    // Menampilkan halaman awal kategori
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar kategori',
            'list' => ['Home', 'kategori']
        ];

        $page = (object) [
            'title' => 'Daftar kategori yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kategori'; // Set menu yang sedang aktif

        // Ambil data kategori dari model KategoriModel
        $kategoris = KategoriModel::all();

        return view('kategori.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'kategoris' => $kategoris // Kirim data kategori ke view
        ]);
    }

    // Ambil data kategori dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        // Mengambil data kategori menggunakan ORM Eloquent
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        if ($request->kategori_id) {
            $kategoris->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($kategoris)
            // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // Menambahkan kolom aksi (tombol-tombol edit, detail, hapus)
            ->addColumn('aksi', function ($kategori) {
                // Tombol detail
                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // Tombol edit
                $btn .= ' <a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                // Tombol hapus (menggunakan form POST dengan metode DELETE)
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
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

    // Menampilkan halaman form tambah kategori
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah kategori',
            'list' => ['Home', 'kategori', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah kategori baru'
        ];

        $activeMenu = 'kategori'; // Set menu yang sedang aktif

        return view('kategori.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategoris,kategori_kode',
            'kategori_nama' => 'required|string|max:100',
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    // Menampilkan detail kategori
    public function show(string $id)
    {
        // Mengambil data kategori menggunakan ID
        $kategori = KategoriModel::find($id);

        // Membuat breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail kategori',
            'list' => ['Home', 'kategori', 'Detail']
        ];

        // Menentukan judul halaman
        $page = (object) [
            'title' => 'Detail kategori'
        ];

        // Menentukan menu yang aktif
        $activeMenu = 'kategori';

        // Mengarahkan ke view dengan data yang dibutuhkan
        return view('kategori.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit kategori
    public function edit(string $id)
    {
        // Ambil data kategori berdasarkan ID
        $kategori = KategoriModel::find($id);

        // Membuat breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Edit kategori',
            'list' => ['Home', 'kategori', 'Edit']
        ];

        // Menentukan judul halaman
        $page = (object) [
            'title' => 'Edit kategori'
        ];

        // Menentukan menu yang aktif
        $activeMenu = 'kategori';

        // Mengarahkan ke view 'kategori.edit' dengan data yang dibutuhkan
        return view('kategori.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data kategori
    public function update(Request $request, string $id)
    {
        // Validasi input form
        $request->validate([
            'kategori_kode' => 'required|string|max:10|unique:m_kategoris,kategori_kode,' . $id . ',kategori_id',
            'kategori_nama' => 'required|string|max:100'
        ]);

        // Update data kategori
        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        // Redirect kembali ke halaman daftar kategori dengan pesan sukses
        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }

    // Menghapus kategori
    public function destroy(string $id)
    {
        // Mengecek apakah data kategori dengan id yang dimaksud ada atau tidak
        $check = KategoriModel::find($id);
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            // Hapus data kategori
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}