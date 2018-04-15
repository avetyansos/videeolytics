@extends('backoffice.layout')

@section('title', 'Video details')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="element-wrapper">
                <h6 class="element-header">Video (Session Id: {{ $model->sessionId }})</h6>
                <div class="element-box text-center">
                    @if ($model->video)
                        <video id="video" style="min-width: 280px;" controls>
                            <source src="{{ $model->video }}" type="video/mp4">
                        </video>
                    @else
                        <div class="alert alert-danger">Unable to load video file</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <div class="row">
        <div class="col-lg-12">
            <div class="element-wrapper">
                <h6 class="element-header">Video details</h6>
                <div class="element-box">
                    <div class="d-flex justify-content-between align-items-center"><span class="badge badge-success">Current event</span> <strong id="current-event" class="badge badge-light ml-2"></strong></div>
                </div>
                <div class="element-box" style="max-height: 500px; overflow-y: scroll;">
                    @if ($model->events !== false)
                        <ul class="list-unstyled">
                        @forelse($model->events as $event)
                            <li class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                                {{ $event['name'] ?? '' }}
                                <span class="badge badge-primary ml-2">{{ $event['type'] ?? '' }} ({{ floor(($event['timestamp'] ?? 0) / 60000) }}:{{ floor(($event['timestamp'] ?? 0) / 1000) }})</span>
                            </li>
                        @empty
                            <li class="alert alert-warning">Events data not exists or incorrect</li>
                        @endforelse
                        </ul>
                    @else
                        <div class="alert alert-danger">Unable to load events file data</div>
                    @endif
                </div>
                <div class="element-box">
                    <ul class="list-unstyled">
                        <li class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                            Date
                            <span class="badge badge-primary badge-pill">{{ $model->startTime->diffForHumans() }} ({{ $model->startTime->format('d.m.Y H:i:s') }})</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                            Duration
                            <span class="badge badge-primary badge-pill">{{ round($model->duration/1000) }} sec</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                            User
                            <span class="badge badge-primary badge-pill">{{ $model->userIdentifier }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                            Device Id
                            <span class="badge badge-primary badge-pill">{{ $model->deviceId }}</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center pb-1 mb-1 border-bottom">
                            Device model
                            <span class="badge badge-primary badge-pill">{{ $model->deviceModel }} ({{ $model->platform }} {{ $model->osVersion }})</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="text/javascript">
        $(function (e) {
            let events = {!! $model->events ? json_encode($model->events) : '[]' !!};
            events = events.map(function(item) {
                item.timestamp /= 1000;
                return item;
            });
            const $video = $('#video');
            const $textBlock = $('#current-event');
            let index = 0;
            let lastTime = 0;
            $video.on("timeupdate", function(event) {
                if (this.currentTime < lastTime) {
                    index = 0;
                }
                lastTime = this.currentTime;
                for (let i=index; i < events.length; i++) {
                    if (this.currentTime >= events[i].timestamp) {
                        //console.log(this.currentTime , events[i].timestamp, i);
                        $textBlock.html(events[i].name);
                        ++index;
                        break;
                    }
                }
            })
        })
    </script>
@endsection