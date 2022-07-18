<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class WebviewController extends Controller
{
    public function about(Request $request) {
        $lang = $request->lang;
        $setting = Setting::where('id', 1)->select('about_app')->first();
        $text = $setting->getTranslations('about_app')[$lang];

        return view('webview.about', compact('text', 'lang'));
    }

    public function terms(Request $request) {
        $lang = $request->lang;
        $setting = Setting::where('id', 1)->select('terms_conditions')->first();
        $text = $setting->getTranslations('terms_conditions')[$lang];

        return view('webview.terms', compact('text', 'lang'));
    }
}
