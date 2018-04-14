@extends('backoffice.layout')

@section('title', 'Analytics videos')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="element-wrapper">
                <h6 class="element-header">
                    Analytics videos
                </h6>
                <div class="element-box">
                    <div class="table-responsive">
                        {!! $grid->show('videos-table') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection