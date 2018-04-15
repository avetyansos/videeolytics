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
                    <div class="mb-3">
                        <form class="form-inline">
                            <div class="form-group mr-3">
                                <input class="form-control form-control-sm bright" placeholder="User" type="text" name="f[userIdentifier]" value="{{ $grid->getFilter('userIdentifier', '') }}">
                            </div>
                            <div class="form-group mr-3">
                                <input class="form-control form-control-sm bright filter-helper" data-type="date" placeholder="Date" name="f[startTime]" type="text" value="{{ $grid->getFilter('startTime', '') }}">
                            </div>
                            <div class="form-group mr-3">
                                <select class="form-control form-control-sm bright styled-select" name="f[platform]">
                                    <option value="">Platform (OS)</option>
                                    <option value="ios" {{ $grid->getFilter('platform', '') === 'ios' ? ' selected' : '' }}>
                                        iOS
                                    </option>
                                    <option value="android" {{ $grid->getFilter('platform', '') === 'android' ? ' selected' : '' }}>
                                        Android
                                    </option>
                                </select>
                            </div>
                            <div class="btn-group">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success"><i class="os-icon os-icon-search"></i></button>
                                    <a href="{{ route('backoffice.analytics') }}" class="btn btn-danger"><i class="os-icon os-icon-refresh-cw"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                        {!! $grid->show('videos-table') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection