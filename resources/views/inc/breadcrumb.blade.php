<?php /*?><ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    {!! getFrontEndBreadcrumb($all_pages, $page->id) !!}
</ul>
<script>
    $("document").ready(function() {
        var last = $("ul.breadcrumb>li:last-child");
        var last_item = last.find("a").text();
        last.addClass("active");
        last.text(last_item);
    });
</script><?php */?>
<div class="breadcrumb-wrap">
					<div class="container">
						 <ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="/">Home</a></li>
							<li class="breadcrumb-item active">{{$page->title}}</li>
						 </ol>
					</div>
				</div>