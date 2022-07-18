
@extends('admin.layouts.app')

@section('title' , translate('About app', 'settings'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                    <h4>{{ translate('About app', 'settings') }}</h4>
             </div>
    </div>
    <form action="{{ route('settings.aupdate') }}" method="post" enctype="multipart/form-data" >
        @csrf
        @method('PUT')
        @foreach ($data['languages'] as $lang)
        <input type="hidden" name="lang[]" value="{{ $lang->code }}" />
        <div class="form-group mb-4 arabic-direction">
            <label for="aboutapp{{ $lang->code }}">{{ translate('About app', 'settings') }} ( {{ $lang->name }} )</label>
            <textarea id="editor-ck-{{ $lang->code }}" required name="about_app[]" class="form-control" id="aboutapp{{ $lang->code }}" rows="5">{{ $data['setting']->getTranslations('about_app')[$lang->code] }}</textarea>
        </div> 
        @endforeach               
        <input type="submit" value="{{ translate('Update', 'roles') }}" class="btn btn-primary">
    </form>
</div>


@endsection
