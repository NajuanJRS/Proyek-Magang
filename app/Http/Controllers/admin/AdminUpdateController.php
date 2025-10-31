<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminUpdateController extends Controller
{
    public function index(): View
    {
        $adminUpdate = User::first();
        return view('Admin.adminUpdate', compact('adminUpdate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'name.min' => 'Username minimal :min karakter.',
            'name.max' => 'Username maximal :max karakter.',
            'password.min' => 'Password minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi password salah.',
        ];

        $validator = Validator::make($request->all(),[
            'name' => 'nullable|string|min:5|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ], $messages);

        if ($validator->fails()) {
            return back()
            ->withErrors($validator)
        ->withInput();
        }

    try {
        $adminUpdate = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ];

        $adminUpdate->update($data);

        return redirect()->route('admin.adminUpdate.index')->with('success', 'Akun Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }
}
