<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Models\admin\Jabatan;
use App\Models\admin\KategoriHeader;
use App\Models\admin\Pejabat;
use App\Traits\ManajemenGambarTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PejabatController extends Controller
{
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        // Data pejabat
        $pejabatQuery = Pejabat::with('jabatan');
        if ($search) {
            $pejabatQuery->where('nama_pejabat', 'like', "%{$search}%")
                         ->orWhereHas('jabatan', fn($q) => $q->where('nama_jabatan', 'like', "%{$search}%"));
        }
        $pejabat = $pejabatQuery->paginate(10);

        $headerKartu = Header::with('kategoriHeader')
            ->when($search, function ($query, $search) {
                $query->where('headline', 'like', "%$search%")
                    ->orWhere('sub_heading', 'like', "%$search%");
            })
            ->paginate(10);


        return view('Admin.profile.pejabat.pejabat', compact('pejabat', 'headerKartu'));
    }

    /**
     * Form tambah pejabat
     */
    public function create(): View
    {
        $jabatan = Jabatan::all();
        return view('Admin.profile.pejabat.formPejabat', compact('jabatan'));
    }

    /**
     * Simpan data pejabat baru
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
        'nama_pejabat.required' => 'Nama pejabat wajib diisi.',
        'nama_pejabat.min' => 'Nama pejabat minimal harus berisi :min karakter.',
        'nama_pejabat.max' => 'Nama pejabat maksimal :max karakter.',
        'id_jabatan.required' => 'Jabatan wajib dipilih.',
        'id_jabatan.exists' => 'Jabatan yang dipilih tidak valid.',
        'gambar.required' => 'Gambar pejabat wajib diunggah.',
        'gambar.image' => 'File harus berupa gambar.',
        'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
        'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'nama_pejabat' => 'required|string|min:5|max:100',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ], $messages);

    $validator->after(function ($validator) use ($request) {
        if (Pejabat::where('id_jabatan', $request->id_jabatan)->exists()) {
            $validator->errors()->add('id_jabatan', 'Jabatan ini sudah diisi oleh pejabat lain.');
        }
    });

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'pejabat',
                'pejabat'
            );
             if (!$pathGambar) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar pejabat.'])->withInput();
            }
        } else {
             return redirect()->back()->withErrors(['gambar' => 'Gambar pejabat wajib diunggah.'])->withInput();
        }

        Pejabat::create([
            'id_user' => $idUser,
            'nama_pejabat' => $request->nama_pejabat,
            'id_jabatan' => $request->id_jabatan,
            'gambar' => $pathGambar,
        ]);

        Cache::forget('profil_pejabat_kepala');
        Cache::forget('profil_pejabat_lainnya');

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Ditambahkan!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Form edit pejabat
     */
    public function edit(Pejabat $pejabat): View
    {
        $jabatan = Jabatan::all();
        return view('Admin.profile.pejabat.formEditPejabat', compact('pejabat', 'jabatan'));
    }


    /**
     * Form edit background kartu pejabat
     */
    public function editHeader($id): View
    {
        $headerKartu = Header::findOrFail($id);
        // KategoriHeader tidak perlu
        return view('Admin.profile.pejabat.formEditKartuPejabat', compact('headerKartu'));
    }

    /**
     * Update data pejabat
     */
    public function update(Request $request, Pejabat $pejabat): RedirectResponse
    {
        $messages = [
        'nama_pejabat.required' => 'Nama pejabat wajib diisi.',
        'nama_pejabat.min' => 'Nama pejabat minimal harus berisi :min karakter.',
        'nama_pejabat.max' => 'Nama pejabat maksimal :max karakter.',
        'id_jabatan.required' => 'Jabatan wajib dipilih.',
        'id_jabatan.exists' => 'Jabatan yang dipilih tidak valid.',
        'gambar.required' => 'Gambar pejabat wajib diunggah.',
        'gambar.image' => 'File harus berupa gambar.',
        'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
        'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'nama_pejabat' => 'required|string|min:5|max:100',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ], $messages);

        $validator->after(function ($validator) use ($request, $pejabat) {
            $jabatanSudahTerisi = Pejabat::where('id_jabatan', $request->id_jabatan)
                ->where('id_pejabat', '!=', $pejabat->id_pejabat)
                ->exists();

            if ($jabatanSudahTerisi) {
                $validator->errors()->add('id_jabatan', 'Jabatan ini sudah diisi oleh pejabat lain.');
            }
        });

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        try {
        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $data = [
            'id_user' => $idUser,
            'nama_pejabat' => $request->nama_pejabat,
            'id_jabatan' => $request->id_jabatan,
        ];

        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($pejabat->gambar);
            $pathGambarBaru = $this->prosesDanSimpanGambar($request->file('gambar'), 'pejabat', 'pejabat');
             if (!$pathGambarBaru) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar pejabat baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru;
        }

        $pejabat->update($data);

        Cache::forget('profil_pejabat_kepala');
        Cache::forget('profil_pejabat_lainnya');
        Cache::forget('jabatan_kepala_dinas_id');

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Update background kartu pejabat
     */
    public function updateHeader(Request $request, $id): RedirectResponse // Tambah RedirectResponse
    {
        $headerKartu = Header::findOrFail($id);

        $messages = [
        'gambar.image' => 'File harus berupa gambar.',
        'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, svg, atau webp.',
        'gambar.max' => 'Ukuran gambar maksimal :max KB.',
        ];

        $validator = Validator::make($request->all(),[
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:5120',
        ], $messages);

        if ($validator->fails()) {
        return back()
        ->withErrors($validator)
        ->withInput();
        }

        $data = [];

        try {
        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($headerKartu->gambar);
            $pathGambarBaru = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'background_pejabat',
                'header'
            );
            if (!$pathGambarBaru) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar background baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru;
        } else {
             return redirect()->back()->withErrors(['gambar' => 'Gambar background wajib diunggah.'])->withInput();
        }

        $headerKartu->update($data);

        Cache::forget('profil_pejabat_background');

        return redirect()->route('admin.pejabat.index')->with('success', 'Background Kepala Pejabat Berhasil Diperbarui!');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['general' => 'Terjadi kesalahan: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Pejabat $pejabat): RedirectResponse
    {
        $this->hapusGambarLama($pejabat->gambar);

        $pejabat->delete();

        Cache::forget('profil_pejabat_kepala');
        Cache::forget('profil_pejabat_lainnya');

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Dihapus!');
    }
}
