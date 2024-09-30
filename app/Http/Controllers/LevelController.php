<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    // Menampilkan halaman awal level
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level yang terdaftar dalam sistem'
        ];

        $activeMenu = 'level'; // Set menu yang sedang aktif

        // Ambil data level dari model LevelModel
        $levels = LevelModel::all();

        return view('level.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'levels' => $levels // Kirim data level ke view
        ]);
    }

    // Ambil data level dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        // Mengambil data level menggunakan ORM Eloquent
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        if ($request->level_id) {
            $levels->where('level_id', $request->level_id);
        }

        return DataTables::of($levels)
            // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // Menambahkan kolom aksi (tombol-tombol edit, detail, hapus)
            ->addColumn('aksi', function ($level) {
                // Tombol detail
                $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // Tombol edit
                $btn .= ' <a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                // Tombol hapus (menggunakan form POST dengan metode DELETE)
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
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

    // Menampilkan halaman form tambah level
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah level baru'
        ];

        $activeMenu = 'level'; // Set menu yang sedang aktif

        return view('level.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data level baru
    public function store(Request $request)
    {
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
            'level_nama' => 'required|string|max:100',
        ]);

        LevelModel::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    // Menampilkan detail level
    public function show(string $id)
    {
        // Mengambil data level menggunakan ID
        $level = LevelModel::find($id);

        // Membuat breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        // Menentukan judul halaman
        $page = (object) [
            'title' => 'Detail level'
        ];

        // Menentukan menu yang aktif
        $activeMenu = 'level';

        // Mengarahkan ke view dengan data yang dibutuhkan
        return view('level.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit level
    public function edit(string $id)
    {
        // Ambil data level berdasarkan ID
        $level = LevelModel::find($id);

        // Membuat breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        // Menentukan judul halaman
        $page = (object) [
            'title' => 'Edit level'
        ];

        // Menentukan menu yang aktif
        $activeMenu = 'level';

        // Mengarahkan ke view 'level.edit' dengan data yang dibutuhkan
        return view('level.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data level
    public function update(Request $request, string $id)
    {
        // Validasi input form
        $request->validate([
            'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100'
        ]);

        // Update data level
        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        // Redirect kembali ke halaman daftar level dengan pesan sukses
        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }

    // Menghapus level
    public function destroy(string $id)
    {
        // Mengecek apakah data level dengan id yang dimaksud ada atau tidak
        $check = LevelModel::find($id);
        if (!$check) {
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            // Hapus data level
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}