<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KontakMasuk;
use App\Models\admin\KotakMasuk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KotakMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kotakMasuk = KotakMasuk::orderBy('id_kotak', 'desc')
                    ->paginate(10);
        return view('Admin.pesan.kotakMasuk', compact('kotakMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KotakMasuk $kotakMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KotakMasuk $kotakMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KotakMasuk $kotakMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kotakMasuk = KotakMasuk::findOrFail($id);
        $kotakMasuk->delete();
        return redirect()->route('admin.kotakMasuk.index')->with('success', 'Pesan Berhasil Dihapus!');
    }
}
