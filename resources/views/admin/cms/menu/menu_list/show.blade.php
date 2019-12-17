@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('menu-list.index', $menu) }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{ $title ?? '-' }}</h1>
            @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('admin_menu_list_crud', $menu, 'Show', route('menu-list.show', ['menu' => $menu, 'id' => $menu_list->id]))])
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Title</strong>: {{ $menu_list->title }}
                            </div>
                            <div class="form-group">
                                <strong>Page</strong>: {{ getActivePage($pages, $menu_list->page_id) }}
                            </div>
                            <div class="form-group">
                                <strong>View Order</strong>: {{ $menu_list->view_order }}
                            </div>
                            <div class="form-group">
                                <strong>Status</strong>: {{ getActiveStatus($menu_list->status) }}
                            </div>
                            <div class="form-group">
                                <strong>Created At</strong>: {{ $menu_list->created_at->format('d M, Y h:i A') }}
                            </div>
                            <div class="form-group">
                                <strong>Updated At</strong>: {{ $menu_list->updated_at->format('d M, Y h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
