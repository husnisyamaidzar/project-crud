<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    public function index()
    {
        $kegiatans = Kegiatan::all();
        return response()->json($kegiatans);
    }

    public function dashboard()
    {
        $kegiatans = Kegiatan::all();

        return view('dashboard', compact('kegiatans'));
    }

    public function store(Request $request)
    {
        $validasi = $request->validate([
            'id_kegiatan' => 'required|string',
            'nama_kegiatan' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'lokasi' => 'required|string',
            'penyelenggara' => 'required|string'
        ]);

        $kegiatan = Kegiatan::create([
            'id_kegiatan' => $validasi['id_kegiatan'],
            'nama_kegiatan' => $validasi['nama_kegiatan'],
            'tanggal_kegiatan' => $validasi['tanggal_kegiatan'],
            'lokasi' => $validasi['lokasi'],
            'penyelenggara' => $validasi['penyelenggara']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $kegiatan
        ], 201);
    }

    public function show($id)
    {
        $kegiatan = Kegiatan::find($id);
        return response()->json($kegiatan);
    }

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);
        $validasi = $request->validate([
            'id_kegiatan' => 'required|string',
            'nama_kegiatan' => 'required|string',
            'tanggal_kegiatan' => 'required|date',
            'lokasi' => 'required|string',
            'penyelenggara' => 'required|string'
        ]);

        $updateData = [
            'id_kegiatan' => $validasi['id_kegiatan'],
            'nama_kegiatan' => $validasi['nama_kegiatan'],
            'tanggal_kegiatan' => $validasi['tanggal_kegiatan'],
            'lokasi' => $validasi['lokasi'],
            'penyelenggara' => $validasi['penyelenggara']
        ];

        $kegiatan->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $kegiatan
        ], 201);

    }

    public function destroy($id)
    {
        $kegiatan = Kegiatan::find($id);
        $kegiatan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
            'data' => $kegiatan
        ], 201);
    }

    public function report()
    {
        $kegiatans = Kegiatan::get();
        return view('pdf.report', compact('kegiatans'));
    }

}
