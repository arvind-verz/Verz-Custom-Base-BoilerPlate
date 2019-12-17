@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('system_settings')])
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.system-settings.update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="site_title">Site Title</label>
                                        <input type="text" name="site_title" class="form-control" id=""
                                            value="{{ $system_setting->site_title ?? old('site_title') }}">

                                        @if ($errors->has('site_title'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('site_title') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="site_description">Site Description</label>
                                        <textarea class="form-control"
                                            name="site_description">{{ $system_setting->site_description ?? old('site_description') }}</textarea>
                                        @if ($errors->has('site_description'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('site_description') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="site_keywords">Site Keywords</label>
                                        <input type="text" name="site_keywords" class="form-control" id=""
                                            value="{{ $system_setting->site_keywords ?? old('site_keywords') }}">
                                        @if ($errors->has('site_keywords'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('site_keywords') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="section-title">Site Logo</div>
                                        <div class="custom-file">
                                            <input type="file" name="logo" class="custom-file-input" id="customFile1">
                                            <label class="custom-file-label" for="customFile1">Choose file</label>
                                            <small class="text-muted">
                                                Logo size should be 470*85 for better resolution. Only png, jpg, and gif
                                                files upto 5mb are accepted.
                                            </small>
                                            @if ($errors->has('logo'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('logo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        @if(isset($system_setting->logo))
                                        <img src="{{ asset($system_setting->logo) }}" alt="" width="100px">
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <div class="section-title">Favicon</div>
                                        <div class="custom-file">
                                            <input type="file" name="favicon" class="custom-file-input"
                                                id="customFile2">
                                            <label class="custom-file-label" for="customFile2">Choose file</label>
                                            <small class="text-muted">
                                                Only ico files upto 1mb are accepted.
                                            </small>
                                            @if ($errors->has('favicon'))
                                            <span class="text-danger d-block">
                                                <strong>{{ $errors->first('favicon') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        @if(isset($system_setting->favicon))
                                        <img src="{{ asset($system_setting->favicon) }}" alt="" width="30px">
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="notification_emails">Notification Emails</label>
                                        <input type="text" name="notification_emails" class="form-control" id=""
                                            value="{{ $system_setting->notification_emails ?? old('notification_emails') }}">
                                        <small class="text-muted">
                                            Max 5 emails separated by comma(",")
                                        </small>
                                        @if ($errors->has('notification_emails'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('notification_emails') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="email_sender_name">Email Sender Name</label>
                                        <input type="text" name="email_sender_name" class="form-control" id=""
                                            value="{{ $system_setting->email_sender_name ?? old('email_sender_name') }}">
                                        @if ($errors->has('email_sender_name'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('email_sender_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="from_email">From Email</label>
                                        <input type="text" name="from_email" class="form-control" id=""
                                            value="{{ $system_setting->from_email ?? old('from_email') }}">
                                        @if ($errors->has('from_email'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('from_email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="to_email">To Email</label>
                                        <input type="text" name="to_email" class="form-control" id=""
                                            value="{{ $system_setting->to_email ?? old('to_email') }}">
                                        @if ($errors->has('to_email'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('to_email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="pagination">Pagination</label>
                                        <input type="number" name="pagination" class="form-control" id=""
                                            value="{{ $system_setting->pagination ?? old('pagination', 20) }}" min="20"
                                            max="200">
                                        <small class="text-muted">
                                            Range support from 20 - 200.
                                        </small>
                                        @if ($errors->has('pagination'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('pagination') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="id" value="{{ $system_setting->id ?? '' }}">
                                    <div class="form-group">
                                        <label for="google_analytics_code">Google Analytics Code</label>
                                        <textarea name="google_analytics_code" class="form-control codeeditor" id=""
                                            cols="30"
                                            rows="10">{!! $page->google_analytics_code ?? old('google_analytics_code') !!}</textarea>
                                        @if ($errors->has('google_analytics_code'))
                                        <span class="text-danger d-block">
                                            <strong>{{ $errors->first('google_analytics_code') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                        Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
