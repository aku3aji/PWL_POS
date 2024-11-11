<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        return PenjualanModel::all();
    }

    public function store(Request $request)
    {
        $rules = [
            'penjualan_kode' => 'required|string|min:3|unique:t_penjualan,penjualan_kode',
            'user_id' => 'required|integer|exists:m_user,user_id',
            'pembeli' => 'required|string|max:100',
            'penjualan_tanggal' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Optional image upload
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->storeAs('posts', $image->hashName(), 'public');
        }

        $penjualan = PenjualanModel::create([
            'penjualan_kode' => $request->penjualan_kode,
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image' => $imagePath,
        ]);

        return response()->json($penjualan, 201);
    }

    public function show(PenjualanModel $penjualan)
    {
        return response()->json($penjualan);
    }

    public function update(Request $request, PenjualanModel $penjualan)
    {
        $rules = [
            'penjualan_kode' => 'required|string|min:3|max:20|unique:t_penjualan,penjualan_kode,' . $penjualan->penjualan_id . ',penjualan_id',
            'user_id' => 'required|integer|exists:m_user,user_id',
            'pembeli' => 'required|string|max:100',
            'penjualan_tanggal' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Optional image upload
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'posts/' . $image->hashName();
            if (Storage::disk('public')->exists($penjualan->image)) {
                Storage::disk('public')->delete($penjualan->image);
            }
            $imagePath = $request->file('image')->storeAs('posts', $image->hashName(), 'public');
            $penjualan->image = $imagePath;
        }

        $penjualan->update([
            'penjualan_kode' => $request->penjualan_kode,
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'image' => $penjualan->image,
        ]);

        return response()->json($penjualan);
    }

    public function destroy(PenjualanModel $penjualan)
    {
        if ($penjualan->image && Storage::disk('public')->exists($penjualan->image)) {
            Storage::disk('public')->delete($penjualan->image);
        }

        $penjualan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data penjualan terhapus'
        ]);
    }
}