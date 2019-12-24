@php $banner= get_banner_by_page($page->id) @endphp
@if($banner)
<div class="bn-inner bg" style="background-image: url('{{ asset($banner->banner_image) }}');">
					<img class="bgimg" src="{{ asset($banner->banner_image) }}" alt="About Us" />
					<div class="caption">
						<h1 class="delay-1">{{$page->title}}</h1>
					</div>
				</div>
@endif