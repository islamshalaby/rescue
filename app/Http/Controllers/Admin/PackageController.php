<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PackageRequest;
use App\Models\Language;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:package-list|package-create|package-edit|package-delete', ['only' => ['index','store']]);
         $this->middleware('permission:package-create', ['only' => ['create','store']]);
         $this->middleware('permission:package-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:package-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::orderBy('id', 'desc')->get();

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['languages'] = Language::select('name', 'code')->get();

        return view('admin.packages.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackageRequest $request)
    {
        $validator = $request->validated();
        $langs = $request->lang;
        $titles = $request->title;
        $descriptions = $request->description;
        $title = [];
        $description = [];

        for($i = 0; $i < count($langs); $i++) {
            $title[$langs[$i]] = $titles[$i];
            $description[$langs[$i]] = $descriptions[$i];
        }

        $post = [
            'title' => $title,
            'description' => $description,
            'price' => $request->price,
            'color' => $request->color,
            'period' => $request->period
        ];

        Package::create($post);

        return redirect()->back()->
        with('success', translate('Package created successfully', 'packages'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
