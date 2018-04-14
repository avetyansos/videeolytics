@extends('backoffice.layout')

@section('title', 'Access Rules')

@section('content')



    <div class="row">
        <div class="col-lg-12">
            <div class="element-wrapper">
                <h6 class="element-header">
                    Access Rules
                </h6>
                <div class="element-box">
                    <div class="controls-above-table">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <a class="btn btn-sm btn-primary" href="{{ route('backoffice.access_rule.create') }}">Add rule</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        {!! $grid->show('access-rules-table') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection