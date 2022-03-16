
@extends('admin.layouts.app')

@section('title' , translate('User management', 'users') )

@section('content')
    <div id="tableSimple" class="col-lg-12 col-12 layout-spacing">
        <div class="statbox widget box box-shadow">
            <div class="widget-header">
              <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>{{ translate('User management', 'users') }}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>
                      @can('user-create')
                      <a class="btn btn-success" href="{{ route('users.create') }}"> {{ translate('Create New User', 'users') }}</a>
                      @endcan
                    </h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area">
            <div class="table-responsive"> 
                <table id="html5-extension" class="table table-hover non-hover" style="width:100%">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>{{ translate('Name', 'users') }}</th>
                          <th>{{ translate('Email', 'users') }}</th>
                          <th>{{ translate('Roles', 'users') }}</th>
                          <th width="280px">{{ translate('Action', 'users') }}</th>   
                        </tr>
                    </thead>
                    <tbody>
                      @php
                      $i=0;
                      @endphp
                      @foreach ($data as $key => $user)
                       <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                          @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                              <label class="badge badge-success">{{ $v }}</label>
                            @endforeach
                          @endif
                        </td>
                        <td>
                          <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">{{ translate('Show', 'users') }}</a>
                          @can('user-edit')
                          <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">{{ translate('Edit', 'users') }}</a>
                          @endcan
                          @can('user-delete')
                          {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                                  {!! Form::submit(translate('Delete', 'users'), ['class' => 'btn btn-danger']) !!}
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
@endsection 