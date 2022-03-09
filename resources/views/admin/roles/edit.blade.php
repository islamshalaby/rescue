
@extends('admin.layouts.app')

@section('title' , translate('Edit role', 'roles'))

@section('content')
<div class="col-lg-12 col-12 layout-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">

                    <h4>{{ translate('Edit role', 'roles') }}</h4>
             </div>
    </div>
    <form action="{{ route('roles.update', $role->id) }}" method="post" enctype="multipart/form-data" >
        @csrf
        @method('PATCH')
        
        <div class="form-group mb-4">
            <label for="name">{{ translate('Name', 'roles') }}:</label>
            <input required type="text" name="name" class="form-control" id="name" placeholder="{{ translate('Name', 'roles') }}" value="{{ $role->name }}" >
        </div>
        <div class="form-group mb-4">
            <strong>{{ translate('Permission', 'roles') }}:</strong>
            <br/>
            <div class="row">
                @foreach($permission as $value)
                <div class="col-2">
                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                        {{ $value->name }}</label>
                </div>
                @endforeach
            </div>
            
        </div>
        <input type="submit" value="{{ translate('Update', 'roles') }}" class="btn btn-primary">
    </form>
</div>


@endsection
