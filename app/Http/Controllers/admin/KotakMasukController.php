<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\KontakMasuk;
use App\Models\admin\KotakMasuk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function tandaiDibaca($id)
    {
        $pesan = KotakMasuk::findOrFail($id);

        if ($pesan->status_dibaca == 0) {
            $pesan->update(['status_dibaca' => 1]);
        }

        $count = KotakMasuk::where('status_dibaca', 0)->count();
        Cache::put('unread_kotak_masuk_count', $count, 30); // cache ulang

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    public function unreadCount()
    {
        $count = Cache::remember('unread_kotak_masuk_count', 30, function () {
            return KotakMasuk::where('status_dibaca', 0)->count();
        });
        return response()->json(['count' => $count]);
    }
}
