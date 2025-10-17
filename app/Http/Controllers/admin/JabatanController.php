<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jabatan = Jabatan::when($search, function ($query, $search) {
            $query->where('nama_jabatan', 'like', "%$search%");
        })->paginate(10);

        return view('Admin.konfigurasiKonten.jabatan', compact('jabatan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.konfigurasiKonten.formPejabat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatan,nama_jabatan',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jabatan $jabatan)
    {
        return view('Admin.konfigurasiKonten.detailJabatan', compact('jabatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('Admin.konfigurasiKonten.formEditJabatan', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatan,nama_jabatan,' . $jabatan->id_jabatan,
        ]);

        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan Berhasil Dihapus!');
    }
}
