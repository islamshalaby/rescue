
@extends('admin.layouts.app')

@section('title' , translate('Create new package', 'packages'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                    <h4>{{ translate('Create new package', 'packages') }}</h4>
             </div>
    </div>
    <form action="{{ route('packages.store') }}" method="post" enctype="multipart/form-data" >
        @csrf
        @foreach ($data['languages'] as $lang)
        <input type="hidden" name="lang[]" value="{{ $lang->code }}" />
        <div class="form-group mb-4">
            <label for="name{{ $lang->code }}">{{ translate('Title', 'packages') }} ( {{ $lang->name }} ):</label>
            <input required type="text" name="title[]" class="form-control" id="name{{ $lang->code }}" placeholder="{{ translate('Name', 'roles') }}" value="" >
        </div>
        <div class="form-group mb-4 arabic-direction">
            <label for="description{{ $lang->code }}">{{ translate('Description', 'packages') }} ( {{ $lang->name }} ):</label>
            <textarea id="description{{ $lang->code }}" name="description[]" required  class="form-control"  rows="5"></textarea>
        </div>
        @endforeach
        <div class="form-group mb-4">
            <label for="price">{{ translate('Price', 'packages') }}:</label>
            <input required type="number" step="any" min="0" name="price" class="form-control" id="price" placeholder="{{ translate('Price', 'packages') }}" value="" >
        </div>
        <div class="form-group mb-4">
            <label for="color">{{ translate('Color', 'packages') }}:</label>
            <input required type="text" name="color" class="form-control" id="color" placeholder="{{ translate('Color', 'packages') }}" value="" >
        </div>
        <div class="form-group mb-4">
            <label for="period">{{ translate('Period', 'packages') }}:</label>
            <input required type="number" name="period" class="form-control" id="period" placeholder="{{ translate('Period', 'packages') }}" value="" >
        </div>
        
        <input type="submit" value="{{ translate('Submit', 'packages') }}" class="btn btn-primary">
    </form>
</div>

@endsection 