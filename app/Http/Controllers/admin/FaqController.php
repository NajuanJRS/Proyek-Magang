<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $faq = Faq::when($search, function ($query, $search) {
            $query->where('pertanyaan', 'like', "%$search%");
        })->paginate(10);
        return view('Admin.faq.faq', compact('faq'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('Admin.faq.formFaq');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'pertanyaan' => 'required|min:5',
            'jawaban' => 'required|min:5',
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        Faq::create([
            'id_user' => $idUser,
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
            'created_at' => now(),
        ]);

        return redirect()->route('admin.faq.index')->with('success', 'Data Pejabat Berhasil Disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('Admin.faq.formEditFaq', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'nullable|exists:user,id_user',
            'pertanyaan' => 'required|min:5',
            'jawaban' => 'required|min:5',
        ]);
        $faq = Faq::findOrFail($id);
        $idUser = Auth::check() && Auth::user()->role === 'admin'
        ? 1
        : Auth::id();

        $data = [
            'id_user'    => $idUser,
            'pertanyaan' => $request->pertanyaan,
            'jawaban'    => $request->jawaban,
            'created_at'=> now(),
        ];

        $faq->update($data);

        return redirect()->route('admin.faq.index')->with('success', 'Data Berhasil Diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);

        $faq->delete();
        return redirect()->route('admin.faq.index')->with('success', 'Data Berhasil Dihapus!');
    }
}
