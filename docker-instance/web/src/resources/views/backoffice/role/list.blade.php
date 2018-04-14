@extends('backoffice.layout')

@section('title', 'Roles')

@section('content')



    <div class="row">
        <div class="col-lg-12">
            <div class="element-wrapper">
                <h6 class="element-header">
                    Roles
                </h6>
                <div class="element-box">
                    <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <a class="btn btn-sm btn-primary" href="{{ route('backoffice.role.create') }}">Add role</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        {!! $grid->show('roles-table') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection