<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Header;
use App\Models\admin\Jabatan;
use App\Models\admin\KategoriHeader; // Tidak perlu di sini
use App\Models\admin\Pejabat;
use App\Traits\ManajemenGambarTrait; // 1. Panggil Trait
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse; // Tambahkan RedirectResponse
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\Storage; // Tidak perlu lagi

class PejabatController extends Controller
{
    // 2. Gunakan Trait
    use ManajemenGambarTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View // Tambahkan View return type
    {
        $search = $request->input('search');

        // Data pejabat
        $pejabatQuery = Pejabat::with('jabatan');
        if ($search) {
            $pejabatQuery->where('nama_pejabat', 'like', "%{$search}%")
                         ->orWhereHas('jabatan', fn($q) => $q->where('nama_jabatan', 'like', "%{$search}%"));
        }
        $pejabat = $pejabatQuery->paginate(10);


        // Data headerKartu (Hanya ambil 1 data spesifik)
        
        // Asumsi id_kategori_header = 8 untuk Kartu Pejabat
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
    public function create(): View // Hapus parameter Pejabat $pejabat, tambah View return type
    {
        $jabatan = Jabatan::all();
        return view('Admin.profile.pejabat.formPejabat', compact('jabatan'));
    }

    /**
     * Simpan data pejabat baru
     */
    public function store(Request $request): RedirectResponse // Tambah RedirectResponse return type
    {
        // 3. Sesuaikan Validasi
        $request->validate([
            'nama_pejabat' => 'required|string|min:5|max:100',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048', // Naikkan max size
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        // 4. Proses Gambar Pejabat dengan Trait
        $pathGambar = null;
        if ($request->hasFile('gambar')) {
            $pathGambar = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'pejabat',      // Tipe gambar
                'pejabat'       // Folder tujuan
            );
             if (!$pathGambar) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar pejabat.'])->withInput();
            }
        } else {
             // Gambar wajib ada saat create
             return redirect()->back()->withErrors(['gambar' => 'Gambar pejabat wajib diunggah.'])->withInput();
        }

        // 5. Gunakan path dari Trait
        Pejabat::create([
            'id_user' => $idUser,
            'nama_pejabat' => $request->nama_pejabat,
            'id_jabatan' => $request->id_jabatan,
            'gambar' => $pathGambar, // Path hasil Trait
        ]);

        Cache::forget('profil_pejabat_kepala');
        Cache::forget('profil_pejabat_lainnya');

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Ditambahkan!');
    }

    /**
     * Form edit pejabat
     */
    public function edit(Pejabat $pejabat): View // Tambah View return type
    {
        $jabatan = Jabatan::all();
        return view('Admin.profile.pejabat.formEditPejabat', compact('pejabat', 'jabatan'));
    }


    /**
     * Form edit background kartu pejabat
     */
    public function editHeader($id): View // Tambah View return type
    {
        $headerKartu = Header::findOrFail($id);
        // KategoriHeader tidak perlu
        return view('Admin.profile.pejabat.formEditKartuPejabat', compact('headerKartu'));
    }

    /**
     * Update data pejabat
     */
    public function update(Request $request, Pejabat $pejabat): RedirectResponse // Tambah RedirectResponse
    {
        // 6. Sesuaikan Validasi Update Pejabat
        $request->validate([
            'nama_pejabat' => 'required|string|min:5|max:100',
            'id_jabatan' => 'required|exists:jabatan,id_jabatan',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048', // Naikkan max size
        ]);

        $idUser = Auth::check() && Auth::user()->role === 'admin'
            ? 1
            : Auth::id();

        $data = [
            'id_user' => $idUser,
            'nama_pejabat' => $request->nama_pejabat,
            'id_jabatan' => $request->id_jabatan,
        ];

        // 7. Proses Update Gambar Pejabat dengan Trait
        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($pejabat->gambar); // Hapus gambar lama
            $pathGambarBaru = $this->prosesDanSimpanGambar($request->file('gambar'), 'pejabat', 'pejabat');
             if (!$pathGambarBaru) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar pejabat baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru; // Gunakan path baru
        }

        $pejabat->update($data);

        Cache::forget('profil_pejabat_kepala');
        Cache::forget('profil_pejabat_lainnya');
        // Juga bersihkan cache id jabatan kadin, untuk jaga-jaga
        Cache::forget('jabatan_kepala_dinas_id');

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Diperbarui!');
    }

    /**
     * Update background kartu pejabat
     */
    public function updateHeader(Request $request, $id): RedirectResponse // Tambah RedirectResponse
    {
        $headerKartu = Header::findOrFail($id);

        // 8. Sesuaikan Validasi Update Background
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:5120', // Gambar wajib, naikkan max size
        ]);

        $data = []; // Hanya update gambar

        // 9. Proses Update Gambar Background dengan Trait
        if ($request->hasFile('gambar')) {
            $this->hapusGambarLama($headerKartu->gambar); // Hapus gambar lama
            $pathGambarBaru = $this->prosesDanSimpanGambar(
                $request->file('gambar'),
                'background_pejabat', // Tipe gambar background
                'header'              // Simpan di folder header (sesuai Trait)
            );
            if (!$pathGambarBaru) {
                 return redirect()->back()->withErrors(['gambar' => 'Gagal memproses gambar background baru.'])->withInput();
            }
            $data['gambar'] = $pathGambarBaru; // Gunakan path baru
        } else {
             // Gambar wajib diisi untuk method ini
             return redirect()->back()->withErrors(['gambar' => 'Gambar background wajib diunggah.'])->withInput();
        }

        $headerKartu->update($data); // Update hanya field gambar

        Cache::forget('profil_pejabat_background');

        return redirect()->route('admin.pejabat.index')->with('success', 'Background Kepala Pejabat Berhasil Diperbarui!');
    }

    /**
     * Hapus data pejabat
     */
    public function destroy(Pejabat $pejabat): RedirectResponse // Tambah RedirectResponse
    {
        // 10. Gunakan Trait untuk Hapus Gambar Pejabat
        $this->hapusGambarLama($pejabat->gambar);

        $pejabat->delete();

        Cache::forget('profil_pejabat_kepala');
        Cache::forget('profil_pejabat_lainnya');

        return redirect()->route('admin.pejabat.index')->with('success', 'Informasi Pejabat Berhasil Dihapus!');
    }
}
