@extends('layouts.app')

@section('content')

<div class="main-wrap">   
				 @include('inc.banner')
				 @include('inc.breadcrumb')	
				{!! $page->content !!}
</div>
@endsection
