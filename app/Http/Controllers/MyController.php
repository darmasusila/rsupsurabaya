<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MyController extends Controller
{
    public static function goToPost($id)
    {
        $id = decrypt($id);
        $postlike = \App\Models\PostingLiked::find($id);
        if ($postlike) {
            // update data
            $postlike->is_open_link = true;
            $postlike->tanggal_liked = now();
            $postlike->save();

            $post = $postlike->posting;

            if ($post) {
                return redirect($post->url);
            }
        }
        return redirect()->back()->with('error', 'Posting not found.');
    }

    public static function openFile($fileName)
    {
        $filePath = storage_path('app/public/' . $fileName);

        if (file_exists($filePath)) {
            // hitung counter
            $dokumen = \App\Models\Dokumen::where('file_name', '"' . $fileName . '"')->first();

            if ($dokumen) {
                $dokumen->counter += 1;
                $dokumen->save();
            }
            return response()->file($filePath);
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    public static function register()
    {
        $biodata = \App\Models\Biodata::select('nama', 'id')
            ->whereNotIn(
                'email',
                function ($query) {
                    $query->select('email')->from('users');
                }
            )
            ->orWhere('email', '=', null)
            ->orderBy('nama', 'asc')
            ->get();

        $dtNama = array('' => 'Pilih Nama');
        foreach ($biodata as $data) {
            $dtNama[encrypt($data->id)] = $data->nama;
        }


        return view('filament.pages.register', compact('dtNama'));
    }

    public static function registerStore(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|max:17',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // jika validasi sudah benar maka ambil biodata dahulu sesuai yang dipilih
        $biodata = \App\Models\Biodata::find(decrypt($request->nama));
        if (!$biodata) {
            return redirect()->back()->withErrors(['nama' => 'Biodata tidak ditemukan.']);
        }

        // cek nik yang diinput dengan nik biodata
        if ($biodata->nik !== $request->nik) {
            return redirect()->back()->withErrors(['nik' => 'NIK tidak valid dengan nama ' . $biodata->nama . '.']);
        }

        // Create the user
        $data = [
            'nik' => $request->nik,
            'name' => $biodata->nama,
            'email' => $request->email,
            // 'email_verified_at' => now(), // Set verified to true
            'password' => bcrypt('password'), // use NIK as password
        ];
        $user = \App\Models\User::create($data);

        $user->assignRole('User');

        Auth::login($user);
        return redirect()->route('filament.admin.pages.dashboard')->with('success', 'Registration successful!');
    }
}
