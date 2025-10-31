<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Kontak;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $messages = [
            'nomor_telepon.required' => 'Nomor telepon wajib diisi.',
            'nomor_telepon.numeric' => 'Nomor telepon harus berisi angka.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email harus example@example.com',
            'jam_pelayanan.required' => 'Jam pelayanan wajib diisi.',
            'map.required' => 'Link Map wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
        ];
        $validator = Validator::make($request->all(),[
            'nomor_telepon' => 'required|numeric',
            'email' => 'required|email',
            'jam_pelayanan' => 'required',
            'map' => 'required',
            'alamat' => 'required',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $kontak = Kontak::findOrFail($id);

        $data = [
            'nomor_telepon'      => $request->nomor_telepon,
            'email' => $request->email,
            'jam_pelayanan' => $request->jam_pelayanan,
            'map'     => $request->map,
            'alamat'=> $request->alamat,
        ];

        $kontak->update($data);

        return redirect()->route('admin.kontak.index')->with('success', 'Kontak Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
