<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function editAbout()
    {
        $setting = SiteSetting::getSetting();

        return view('tentang', compact('setting'));
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'about_description' => ['required', 'string', 'max:2000'],
            'vision' => ['required', 'string', 'max:1000'],
            'mission' => ['required', 'string', 'max:1000'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $setting = SiteSetting::getSetting();

        $data = [
            'about_description' => $request->about_description,
            'vision' => $request->vision,
            'mission' => $request->mission,
        ];

        if ($request->hasFile('banner')) {
            if ($setting->banner_path) {
                Storage::disk('public')->delete($setting->banner_path);
            }

            $data['banner_path'] = $request->file('banner')->store('site', 'public');
        }

        $setting->update($data);

        return redirect()
            ->route('tentang')
            ->with('success', 'Data halaman tentang berhasil diperbarui!');
    }

    public function editContact()
    {
        $setting = SiteSetting::getSetting();

        return view('kontak', compact('setting'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'whatsapp' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'tiktok' => ['nullable', 'string', 'max:100'],
            'footer_text' => ['nullable', 'string', 'max:255'],
        ]);

        $setting = SiteSetting::getSetting();

        $setting->update([
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'address' => $request->address,
            'instagram' => $request->instagram,
            'tiktok' => $request->tiktok,
            'footer_text' => $request->footer_text,
        ]);

        return redirect()
            ->route('kontak')
            ->with('success', 'Data kontak berhasil diperbarui!');
    }
}