@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('slider.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_slider_crud', 'Show',
            route('slider.show', $slider->id))])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="page_id">Page</label>
                                <select name="page_id" class="form-control"
                                    style="font-family: 'FontAwesome', 'Helvetica';">
                                    <option value="">-- Select --</option>
                                    {!! getDropdownPageList($pages, $slider->page_id, $parent_id = 0) !!}
                                </select>
                                @if ($errors->has('page_id'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('page_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="section-title">Slider Image</div>
                                @if($slider->slider_images)
                                @php
                                $slider_images = json_decode($slider->slider_images);
                                @endphp
                                @foreach ($slider_images as $key => $item)
                                <div class="row mb-2 slider">
                                    <div class="col-11">
                                        <div class="form-group">
                                            <label for="">Caption</label>
                                            <input type="text" name="caption[]" class="form-control"
                                                value="{{ old('caption.'.$key, $item->caption) }}">

                                            @if ($errors->has("caption.".$key))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first("caption.".$key) }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="">Slider Image</label>
                                            <div class="custom-file">
                                                <input type="file" name="slider_images[]" class="custom-file-input"
                                                    id="customFile{{ ($key+1) }}">
                                                <input type="hidden" name="slider_images_hidden[]"
                                                    value="{{ $item->slider_image }}">
                                                <label class="custom-file-label" for="customFile{{ ($key+1) }}">Choose
                                                    file</label>
                                                <small class="text-muted">
                                                    Logo size should be 1400x450 for better resolution. Only png, jpg, and
                                                    gif
                                                    files upto 25mb are accepted.
                                                </small>
                                                @if ($errors->has("slider_images.".$key))
                                                <span class="text-danger d-block">
                                                    <strong>{{ $errors->first("slider_images.".$key) }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        @if(isset($item->slider_image))
                                        <div class="d-block">
                                            <a href="{{ asset($item->slider_image) }}" target="_blank"><img
                                                    src="{{ asset($item->slider_image) }}" alt="" width="200px"></a>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">View Order</label>
                                            <input type="number" name="view_order[]" class="form-control"
                                                placeholder="view order" value="{{ $item->view_order }}" min="0">
                                            @if ($errors->has("view_order.".$key))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first("view_order.".$key) }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr/>
                                </div>
                                @endforeach
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="position">Position</label>
                                <select name="position" class="form-control">
                                    <option value="">-- Select --</option>
                                    @if(getPosition())
                                    @foreach (getPosition() as $key => $item)
                                    <option value="{{ $key }}" @if($slider->position==$key) selected @elseif($key==1)
                                        selected
                                        @endif>{{ $item }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('status'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">-- Select --</option>
                                    @if(getActiveStatus())
                                    @foreach (getActiveStatus() as $key => $item)
                                    <option value="{{ $key }}" @if($slider->status==$key) selected @elseif($key==1)
                                        selected
                                        @endif>{{ $item }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('status'))
                                <span class="text-danger d-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        $("input, textarea, select").attr("disabled", true);
    });

</script>
@endsection
