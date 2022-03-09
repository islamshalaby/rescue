
@extends('admin.layouts.app')

@section('title' , translate('Create new role', 'roles'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                    <h4>{{ translate('Create new role', 'roles') }}</h4>
             </div>
    </div>
    <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data" >
        @csrf
        
        <div class="form-group mb-4">
            <label for="name">{{ translate('Name', 'roles') }}:</label>
            <input required type="text" name="name" class="form-control" id="name" placeholder="{{ translate('Name', 'roles') }}" value="{{ old('name') }}" >
        </div>
        <div class="form-group mb-4">
            <strong>{{ translate('Permission', 'roles') }}:</strong>
            <br/>
            <div class="row">
                @foreach($permission as $value)
                <div class="col-2">
                    <label>{{ Form::checkbox('permission[]', $value->id, false , array('class' => 'name')) }}
                        {{ $value->name }}</label>
                </div>
                @endforeach
            </div>
            
        </div>
        <input type="submit" value="{{ translate('Submit', 'roles') }}" class="btn btn-primary">
    </form>
</div>

@endsection 