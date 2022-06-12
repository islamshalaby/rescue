@extends('admin.layouts.app')

@section('title' , translate('Slider management', 'sliders') )

@section('content')
<div id="tableSimple" class="col-lg-12 col-12 layout-spacing">

    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ translate('Slider management', 'sliders') }}</h4>
                </div>
            </div>
            @can('package-create')
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <a class="btn btn-success" href="{{ route('sliders.create') }}">{{ translate('Create new slider', 'sliders') }}</a>
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
                            <th>{{ translate('Image', 'sliders') }}</th>
                            <th width="280px">{{ translate('Action', 'sliders') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach ($data as $key => $row)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td><img style="max-width: 100px" src="{{ $row->image->file_url }}" /> </td>
                        <td>
                            <a class="btn btn-info" href="{{ route('sliders.show',$row->id) }}">{{ translate('Show', 'sliders') }}</a>
                            @can('slider-edit')
                                <a class="btn btn-primary" href="{{ route('sliders.edit',$row->id) }}">{{ translate('Edit', 'sliders') }}</a>
                            @endcan
                            @can('slider-delete')
                                {!! Form::open(['method' => 'DELETE','route' => ['sliders.destroy', $row->id],'style'=>'display:inline']) !!}
                                    {!! Form::submit(translate('Delete', 'sliders'), ['class' => 'btn btn-danger']) !!}
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