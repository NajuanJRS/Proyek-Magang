<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminUpdateController extends Controller
{
    public function index(): View
    {
        $adminUpdate = Auth::User();
        return view('Admin.adminUpdate', compact('adminUpdate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $messages = [
        'name.required'   => 'Username wajib diisi.',
        'name.min'        => 'Username minimal :min karakter.',
        'name.max'        => 'Username maksimal :max karakter.',
        'password.min'    => 'Password minimal :min karakter.',
        'password.confirmed' => 'Konfirmasi password tidak sesuai.',
    ];

    $request->validate([
        'name'     => 'required|string|min:5|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ], $messages);

    try {
        $data = ['name' => $request->name];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        User::whereKey(Auth::id())->update($data);

        return redirect()
            ->route('admin.adminUpdate.index')
            ->with('success', 'Akun berhasil diperbarui!');
    } catch (\Exception $e) {
        return back()
            ->withErrors(['general' => 'Terjadi kesalahan: '.$e->getMessage()])
            ->withInput();
    }
    }
}
