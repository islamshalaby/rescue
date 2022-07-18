
@extends('admin.layouts.app')

@section('title' , translate('Terms and conditions', 'settings'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                    <h4>{{ translate('Terms and conditions', 'settings') }}</h4>
             </div>
    </div>
    <form action="{{ route('settings.tupdate') }}" method="post" enctype="multipart/form-data" >
        @csrf
        @method('PUT')
        @foreach ($data['languages'] as $lang)
        <input type="hidden" name="lang[]" value="{{ $lang->code }}" />
        <div class="form-group mb-4 arabic-direction">
            <label for="termsandconditions{{ $lang->code }}">{{ translate('Terms', 'settings') }} ( {{ $lang->name }} )</label>
            <textarea id="editor-ck-{{ $lang->code }}" required name="terms_conditions[]" class="form-control" id="termsandconditions{{ $lang->code }}" rows="5">{{ $data['setting']->getTranslations('terms_conditions')[$lang->code] }}</textarea>
        </div> 
        @endforeach               
        <input type="submit" value="{{ translate('Update', 'roles') }}" class="btn btn-primary">
    </form>
</div>


@endsection
