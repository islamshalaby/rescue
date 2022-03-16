@extends('admin.layouts.app')

@section('title' , translate('Package management', 'packages') )

@section('content')
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">

    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ translate('Package management', 'packages') }}</h4>
                </div>
            </div>
            @can('package-create')
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <a class="btn btn-success" href="{{ route('packages.create') }}">{{ translate('Create new package', 'packages') }}</a>
                </div>
            </div>
            @endcan
            
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive">
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>{{ translate('Title', 'packages') }}</th>
                            <th width="280px">{{ translate('Action', 'packages') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach ($packages as $key => $package)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $package->title }}</td>
                        <td>
                            <a class="btn btn-info" href="{{ route('packages.show',$package->id) }}">{{ translate('Show', 'packages') }}</a>
                            @can('package-edit')
                                <a class="btn btn-primary" href="{{ route('packages.edit',$package->id) }}">{{ translate('Edit', 'packages') }}</a>
                            @endcan
                            @can('package-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['packages.destroy', $package->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit(translate('Delete', 'packages'), ['class' => 'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection 