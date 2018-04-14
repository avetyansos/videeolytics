@extends('backoffice.layout')

@section('title')
    @if($model->exists)
        Update Access Rule {{ $model->name }}
    @else
        Create Access Rule
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="element-wrapper">
                <h6 class="element-header">
                    @if($model->exists)
                        Update Access Rule {{ $model->name }}
                    @else
                        Create Access Rule
                    @endif
                </h6>
                <div class="element-box">
                    <form method="post" action="{{ $model->exists ? route('backoffice.access_rule.update', ['id' => $model->id]) : route('backoffice.access_rule.store') }}">
                        @csrf
                        @if ($model->exists)
                            @method('PUT')
                        @endif

                        <div class="form-group {{ $errors->has('name') ? ' has-error has-danger' : '' }}">
                            <label for="">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' error-field' : '' }}" name="name" value="{{ old('name', $model->name) }}" placeholder="Access rule name">
                            @if ($errors->has('name'))
                                <span class="help-block form-text with-errors">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="">Access</label>
                            <select name="access" class="form-control {{ $errors->has('access') ? ' error-field' : '' }}">
                                <option value="allow">Allow</option>
                                <option value="deny">Deny</option>
                            </select>
                            @if ($errors->has('access'))
                                <span class="help-block form-text with-errors">{{ $errors->first('access') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="">Resource type</label>
                            <select name="resource_type" class="form-control {{ $errors->has('resource_type') ? ' error-field' : '' }}">
                                <option value="uris" selected>Uris (controller/action)</option>
                                <option value="data" disabled>Data</option>
                            </select>
                            @if ($errors->has('resource_type'))
                                <span class="help-block form-text with-errors">{{ $errors->first('resource_type') }}</span>
                            @endif
                        </div>
                        <fieldset class="form-group cloneable-blocks">
                            <legend>
                                <span>URI resources for this rule
                                <button type="button" class="btn btn-success btn-sm copy-cloneable-block"> <i class="os-icon os-icon-plus"></i></button></span>
                            </legend>

                            @forelse (old('resource_uris', $model->getResourceUris()) as $resourceUri)
                                <div class="row uri-resource cloneable-block mt-3">
                                    <div class="col-sm-6 {{ $errors->has('resource_uris.'.$loop->index) ? ' has-error has-danger' : '' }}">
                                        <div class="form-group">
                                            <label for="">URI Resource</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text p-0 pl-1 pr-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-cloneable-block"> <i class="os-icon os-icon-minus"></i></button>
                                                    </div>
                                                </div>
                                                <select name="resource_uris[]" class="form-control" data-http-method="{{ old('resource_http_methods') ? old('resource_http_methods.'.$loop->index) : $model->getResourceHttpMethods($loop->index) }}">
                                                    <option value=""></option>
                                                    @foreach ($model->getUriResources() as $uri => $methods)
                                                        <option value="{{ $uri }}" data-available-http-methods="{{ implode(',', $methods) }}" {{ $resourceUri === $uri ? 'selected' : '' }}>{{ $uri }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            @if ($errors->has('resource_uris.'.$loop->index))
                                                <span class="help-block form-text with-errors">{{ $errors->first('resource_uris.'.$loop->index) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6 {{ $errors->has('resource_http_methods.'.$loop->index) ? ' has-error has-danger' : '' }}">
                                        <label for="">HTTP method</label>
                                        <select name="resource_http_methods[]" class="form-control">
                                            <option value="">Choose URI at first</option>
                                        </select>

                                        @if ($errors->has('resource_http_methods.'.$loop->index))
                                            <span class="help-block form-text with-errors">{{ $errors->first('resource_http_methods.'.$loop->index) }}</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="row uri-resource cloneable-block mt-3">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">URI Resource</label>

                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text p-0 pl-1 pr-1">
                                                        <button type="button" class="btn btn-sm btn-danger remove-cloneable-block"> <i class="os-icon os-icon-minus"></i></button>
                                                    </div>
                                                </div>
                                                <select name="resource_uris[]" class="form-control">
                                                    <option value=""></option>
                                                    @foreach ($model->getUriResources() as $uri => $methods)
                                                        <option value="{{ $uri }}" data-available-http-methods="{{ implode(',', $methods) }}">{{ $uri }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">HTTP method</label>
                                        <select name="resource_http_methods[]" class="form-control">
                                            <option value="">Choose URI at first</option>
                                        </select>
                                    </div>
                                </div>
                            @endforelse
                            <div class="row uri-resource cloneable-block">
                                <div class="col-sm-6">
                                    @if ($errors->has('resource_uris'))
                                        <span class="help-block form-text with-errors">{{ $errors->first('resource_uris') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-6">
                                    @if ($errors->has('resource_http_methods'))
                                        <span class="help-block form-text with-errors">{{ $errors->first('resource_http_methods') }}</span>
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $model->description }}</textarea>
                            @if ($errors->has('description'))
                                <span class="help-block form-text with-errors">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit"> Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    <script type="application/javascript">
        $(document).ready(function() {
            function processUriMethods($select) {
                const $httpMethod = $select.closest('.uri-resource').find('select[name="resource_http_methods[]"]');
                $httpMethod.empty();

                const methodItem = function(method, httpMethod) {
                    if (method) {
                        return (method === httpMethod) ? '<option value="'+method+'" selected>'+method+'</option>' : '<option value="'+method+'">'+method+'</option>';
                    } else {
                        return '<option value="">Choose URI at first</option>';
                    }
                };

                const httpMethods = ($select.find('option:selected').data('available-http-methods') || '').split(',').map((s) => s.trim());
                const httpMethod = $select.data('http-method') || null;

                httpMethods.forEach(function (item) {
                    $httpMethod.append(methodItem(item, httpMethod));
                });
            }

            const $selects = $('select[name="resource_uris[]"]');
            $selects.each(function () {
                const $select = $(this);
                processUriMethods($select);
                $select.on('change', function(e) {
                    processUriMethods($select);
                });
            });

            const $clonesBlock = $('.cloneable-blocks');
            $clonesBlock.find('.cloneable-block').find('.remove-cloneable-block').on('click', function (e) {
                $(this).closest('.cloneable-block').remove();
            });
            const $cloneable = $clonesBlock.find('.cloneable-block').first().clone(true);
            $cloneable.find(':input').val('');
            $cloneable.find('select[name="resource_uris[]"]').on('change', function(e) {
                processUriMethods($(this));
            });

            $clonesBlock.find('.copy-cloneable-block').on('click', function (e) {
                e.preventDefault();
                $cloneable.clone(true).appendTo($clonesBlock);
            })
        });
    </script>
@endsection