@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_activitylog')])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-md">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Page Name</th>
                                            <th>Updated By</th>
                                            <th>Updated At</th>
                                            <th>Fields Updated</th>
                                            <th>View Action</th>
                                            <th>IP address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($activity_log->count())
                                        @foreach($activity_log as $item)
                                        @php
                                        $subject_type = '';
                                        if($item->subject_type)
                                        {
                                        $subject_type = explode('\\', $item->subject_type);
                                        }
                                        if($item->properties)
                                        {
                                        $properties = json_decode($item->properties);
                                        }
                                        @endphp
                                        <tr>
                                            <td row="scope">{{ $item->acid }}</td>
                                            <td>{{ $subject_type[1] }}</td>
                                            <td>{{ $item->firstname . ' ' . $item->lastname }}</td>
                                            <td>{{ date('d M, Y h:i A', strtotime($item->activity_log_updated)) }}
                                            </td>
                                            <td>
                                                @foreach($properties->attributes as $key => $val)
                                                {{ $key.', ' }}
                                                @endforeach
                                            </td>
                                            <td>{{ ucfirst($item->description) ?? '' }}</td>
                                            <td>{{ getCauserIp($item->causer_id) }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('constant.NO_DATA_FOUND') }}
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $activity_log->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
