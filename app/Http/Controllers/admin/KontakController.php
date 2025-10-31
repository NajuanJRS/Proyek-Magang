<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Kontak;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class KontakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $kontak = Kontak::first();
        return view('Admin.kontak.kontak.kontak', compact('kontak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nomor_telepon' => 'required|numeric',
            'email' => 'required|email',
            'jam_pelayanan' => 'required',
            'map' => 'required',
            'alamat' => 'required',
        ]);
        $kontak = Kontak::findOrFail($id);

        $data = [
            'nomor_telepon'      => $request->nomor_telepon,
            'email' => $request->email,
            'jam_pelayanan' => $request->jam_pelayanan,
            'map'     => $request->map,
            'alamat'=> $request->alamat,
        ];

        $kontak->update($data);

        Cache::forget('kontak_page_data');

        return redirect()->route('admin.kontak.index')->with('success', 'Kontak Berhasil Diperbarui!');
    }
}
