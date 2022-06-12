
@extends('admin.layouts.app')

@section('title' , translate('Create new slider', 'sliders'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                    <h4>{{ translate('Create new slider', 'sliders') }}</h4>
             </div>
    </div>
    <form action="{{ route('sliders.store') }}" method="post" enctype="multipart/form-data" >
        @csrf
        <div class="custom-file-container" data-upload-id="myFirstImage">
            <label>{{ translate('Upload image', 'sliders') }} <a href="javascript:void(0)"
                                                                                      class="custom-file-container__image-clear"
                                                                                      title="Clear Image">x</a></label>
            <label class="custom-file-container__custom-file">
                <input type="file" required name="image"
                       class="custom-file-container__custom-file__custom-file-input" accept="image/*">
                <input type="hidden" name="MAX_FILE_SIZE" value="10485760"/>
                <span class="custom-file-container__custom-file__custom-file-control"></span>
            </label>
            <div class="custom-file-container__image-preview"></div>
        </div>
        
        <div class="form-group mb-4">
            <label for="test">{{ translate('Content', 'sliders') }}:</label>
            <input required type="text" name="content" class="form-control" id="test" placeholder="{{ translate('Content', 'sliders') }}" value="" >
        </div>
        
        <input type="submit" value="{{ translate('Submit', 'packages') }}" class="btn btn-primary">
    </form>
</div>

@endsection 