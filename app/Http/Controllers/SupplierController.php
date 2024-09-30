<?php

namespace App\Http\Controllers;

use App\Models\supplierModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    // Menampilkan halaman awal supplier
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar supplier',
            'list' => ['Home', 'supplier']
        ];

        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];

        $activeMenu = 'supplier'; // Set menu yang sedang aktif

        // Ambil data supplier dari model supplierModel
        $suppliers = supplierModel::all();

        return view('supplier.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'suppliers' => $suppliers // Kirim data supplier ke view
        ]);
    }

    // Ambil data supplier dalam bentuk JSON untuk DataTables
    public function list(Request $request)
    {
        // Mengambil data supplier menggunakan ORM Eloquent
        $suppliers = supplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        if ($request->supplier_id) {
            $suppliers->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($suppliers)
            // Menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            // Menambahkan kolom aksi (tombol-tombol edit, detail, hapus)
            ->addColumn('aksi', function ($supplier) {
                // Tombol detail
                $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a>';
                // Tombol edit
                $btn .= ' <a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a>';
                // Tombol hapus (menggunakan form POST dengan metode DELETE)
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
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

    // Menampilkan halaman form tambah supplier
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah supplier',
            'list' => ['Home', 'supplier', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah supplier baru'
        ];

        $activeMenu = 'supplier'; // Set menu yang sedang aktif

        return view('supplier.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan data supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|string|max:10|unique:m_suppliers,supplier_kode',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:100',
        ]);

        supplierModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    // Menampilkan detail supplier
    public function show(string $id)
    {
        // Mengambil data supplier menggunakan ID
        $supplier = supplierModel::find($id);

        // Membuat breadcrumb
        $breadcrumb = (object) [
            'title' => 'Detail supplier',
            'list' => ['Home', 'supplier', 'Detail']
        ];

        // Menentukan judul halaman
        $page = (object) [
            'title' => 'Detail supplier'
        ];

        // Menentukan menu yang aktif
        $activeMenu = 'supplier';

        // Mengarahkan ke view dengan data yang dibutuhkan
        return view('supplier.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit supplier
    public function edit(string $id)
    {
        // Ambil data supplier berdasarkan ID
        $supplier = supplierModel::find($id);

        // Membuat breadcrumb untuk navigasi
        $breadcrumb = (object) [
            'title' => 'Edit supplier',
            'list' => ['Home', 'supplier', 'Edit']
        ];

        // Menentukan judul halaman
        $page = (object) [
            'title' => 'Edit supplier'
        ];

        // Menentukan menu yang aktif
        $activeMenu = 'supplier';

        // Mengarahkan ke view 'supplier.edit' dengan data yang dibutuhkan
        return view('supplier.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data supplier
    public function update(Request $request, string $id)
    {
        // Validasi input form
        $request->validate([
            'supplier_kode' => 'required|string|max:10|unique:m_suppliers,supplier_kode,' . $id . ',supplier_id',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:100'
        ]);

        // Update data supplier
        supplierModel::find($id)->update([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat
        ]);

        // Redirect kembali ke halaman daftar supplier dengan pesan sukses
        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }

    // Menghapus supplier
    public function destroy(string $id)
    {
        // Mengecek apakah data supplier dengan id yang dimaksud ada atau tidak
        $check = supplierModel::find($id);
        if (!$check) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            // Hapus data supplier
            supplierModel::destroy($id);
            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}