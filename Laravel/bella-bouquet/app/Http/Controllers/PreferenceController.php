<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferenceController extends Controller
{
    public function index(Request $request)
    {
        $theme = $request->cookie('bella_theme', 'light');
        $fontSize = $request->cookie('bella_font_size', 'normal');

        return view('preferensi', compact('theme', 'fontSize'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark,system',
            'font_size' => 'required|in:small,normal,large',
        ]);

        $oldTheme = $request->cookie('bella_theme', 'belum ada');
        $oldFontSize = $request->cookie('bella_font_size', 'belum ada');

        $theme = $request->theme;
        $fontSize = $request->font_size;

        $response = response()->json([
            'success' => true,
            'message' => 'Preferensi berhasil disimpan ke cookie.',
            'cookie_lama' => [
                'theme' => $oldTheme,
                'font_size' => $oldFontSize,
            ],
            'cookie_baru' => [
                'theme' => $theme,
                'font_size' => $fontSize,
            ],
        ]);

        /*
         Parameter penting:
         path: '/'
         httpOnly: false

         Kalau httpOnly true, JavaScript tidak bisa membaca cookie,
         sehingga dark mode tidak bisa diterapkan dari sisi frontend.
        */

        return $response
            ->withCookie(cookie(
                'bella_theme',
                $theme,
                60 * 24 * 30,
                '/',
                null,
                false,
                false
            ))
            ->withCookie(cookie(
                'bella_font_size',
                $fontSize,
                60 * 24 * 30,
                '/',
                null,
                false,
                false
            ));
    }
}