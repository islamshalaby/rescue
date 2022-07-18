
@extends('admin.layouts.app')

@section('title' , translate('Settings', 'settings'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                    <h4>{{ translate('Settings', 'settings') }}</h4>
             </div>
    </div>
    <form action="{{ route('settings.update') }}" method="post" enctype="multipart/form-data" >
        @csrf
        @method('PUT')
        <div class="form-group mb-4 arabic-direction">
            <label for="emergency_message">{{ translate('Emergency message', 'settings') }}</label>
            <textarea id="emergency_message" required name="emergency_message" class="form-control" rows="5">{{ $data['setting']->emergency_message }}</textarea>
        </div>              
        <input type="submit" value="{{ translate('Update', 'roles') }}" class="btn btn-primary">
    </form>
</div>


@endsection
