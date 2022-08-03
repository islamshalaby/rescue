<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:setting-list|terms-edit|about-edit', ['only' => ['index','store']]);
         $this->middleware('permission:terms-edit', ['only' => ['tedit','tupdate']]);
         $this->middleware('permission:about-edit', ['only' => ['aedit','aedit']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms_edit()
    {
        $data['languages'] = Language::select('name', 'code')->get();
        $data['setting'] = Setting::where('id', 1)->select('id', 'terms_conditions')->first();
        
        return view('admin.setting.terms', compact('data'));
    }

    public function terms_update(Request $request)
    {
        $this->validate($request, [
            'terms_conditions' => 'required'
        ]);
        $langs = $request->lang;
        $terms_conditions = $request->terms_conditions;
        $setting = Setting::where('id', 1)->select('id', 'terms_conditions')->first();
        $data = [];
        for($i = 0; $i < count($langs); $i++) {
            $data[$langs[$i]] = $terms_conditions[$i];
        }
        
        $setting->update(['terms_conditions' => $data]);
        
        return redirect()->back()->
        with('success', translate('Terms updated successfully', 'settings'));
    }

    public function about_edit()
    {
        $data['languages'] = Language::select('name', 'code')->get();
        $data['setting'] = Setting::where('id', 1)->select('id', 'about_app')->first();
        
        return view('admin.setting.about', compact('data'));
    }

    public function about_update(Request $request)
    {
        $this->validate($request, [
            'about_app' => 'required'
        ]);
        $langs = $request->lang;
        $about_app = $request->about_app;
        $setting = Setting::where('id', 1)->select('id', 'about_app')->first();
        $data = [];
        for($i = 0; $i < count($langs); $i++) {
            $data[$langs[$i]] = $about_app[$i];
        }
        
        $setting->update(['about_app' => $data]);
        
        return redirect()->back()->
        with('success', translate('Terms updated successfully', 'settings'));
    }

    public function setting_edit()
    {
        $data['setting'] = Setting::where('id', 1)->select('id', 'emergency_message', 'show_buy', 'free_contacts_number')->first();
        
        return view('admin.setting.index', compact('data'));
    }

    public function setting_update(Request $request)
    {
        $this->validate($request, [
            'emergency_message' => 'required',
            'free_contacts_number' => 'required'
        ]);
        
        $setting = Setting::where('id', 1)->select('id', 'emergency_message')->first();
        $post = $request->all();
        $show_buy = 0; 
        if ($request->show_buy) {
            $show_buy = 1;
        }
        $post['show_buy'] = $show_buy;
        
        $setting->update($post);
        
        return redirect()->back()->
        with('success', translate('Terms updated successfully', 'settings'));
    }
}
