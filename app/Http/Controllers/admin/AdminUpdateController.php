<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $adminUpdate = User::findOrFail($id);

        $data = [
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ];

        $adminUpdate->update($data);

        return redirect()->route('admin.adminUpdate.index')->with('success', 'Data Berhasil Diupdate!');
    }
}
