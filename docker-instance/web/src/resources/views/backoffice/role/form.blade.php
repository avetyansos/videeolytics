@extends('backoffice.layout')

@section('title')
    @if($model->exists)
        Update Role {{ $model->name }}
    @else
        Create Role
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="element-wrapper">
                <h6 class="element-header">
                    @if($model->exists)
                        Update Role {{ $model->name }}
                    @else
                        Create Role
                    @endif
                </h6>
                <div class="element-box">
                    <form method="post" action="{{ $model->exists ? route('backoffice.role.update', ['id' => $model->id]) : route('backoffice.role.store') }}">
                        @csrf
                        @if ($model->exists)
                            @method('PUT')
                        @endif

                        <div class="form-group {{ $errors->has('name') ? ' has-error has-danger' : '' }}">
                            <label for="">Name</label>
                            <input type="text" class="form-control {{ $errors->has('name') ? ' error-field' : '' }}" name="name" value="{{ old('name', $model->name) }}" placeholder="Role name">
                            @if ($errors->has('name'))
                                <span class="help-block form-text with-errors">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('slug') ? ' has-error has-danger' : '' }}">
                            <label for="">Slug</label>
                            <input type="text" class="form-control {{ $errors->has('slug') ? ' error-field' : '' }}" name="slug" value="{{ old('slug', $model->slug) }}" placeholder="Role slug">
                            @if ($errors->has('slug'))
                                <span class="help-block form-text with-errors">{{ $errors->first('slug') }}</span>
                            @endif
                        </div>

                        <div class="form-group {{ ($errors->has('access_rules') || $errors->has('access_rules.*')) ? ' has-error has-danger' : '' }}">
                            <label for="">Access rules <span class="badge badge-success">allowed</span> <span class="badge badge-danger">denied</span></label>
                            <select name="access_rules[]" class="form-control select2" multiple>
                                @foreach(\App\Models\AccessRule::all() as $rule)
                                    <option value="{{ $rule->id }}" {{ in_array($rule->id, old('access_rules', $model->accessRules->pluck('id')->all())) ? 'selected' : '' }} data-access="{{ $rule->access }}">{{ $rule->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('access_rules'))
                                <span class="help-block form-text with-errors">{{ $errors->first('access_rules') }}</span>
                            @endif
                            @if ($errors->has('access_rules.*'))
                                <span class="help-block form-text with-errors">{{ $errors->first('access_rules.*') }}</span>
                            @endif
                        </div>

                        <div class="form-buttons-w">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('custom-js')
    <script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
    <script type="text/javascript">
        function getText(data) {
            if (data.element) {
                const $element = $(data.element);
                switch ($element.data('access')) {
                    case 'allow':
                        return '<span class="badge badge-success ml-1">'+$element.html()+'</span>';
                    case 'deny':
                        return '<span class="badge badge-danger ml-1">'+$element.html()+'</span>';
                    default:
                        return $element.text();
                }
            } else {
                return (data.text || 'anonymous');
            }
        }
        $('select.select2').select2({
            placeholder: 'Choose access rules',
            escapeMarkup: function(markup) {
                return markup;
            },
            templateResult: function(data) {
                return getText(data);
            },
            templateSelection: function(data) {
                return getText(data);
            }
        });
    </script>
@endsection