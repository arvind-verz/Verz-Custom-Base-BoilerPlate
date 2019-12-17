@php
    $sidebar = [
        [
            'menu_header'   =>  __('constant.DASHBOARD'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.DASHBOARD'),
                    'icon'  =>  '<i class="fas fa-tachometer-alt"></i>',
                    'url'   =>  'admin/home',
                ],
            ],
        ],
        [
            'menu_header'   =>  __('constant.CMS'),
            'main_menu' =>  [
                [
                    'title' =>  __('constant.PAGES'),
                    'icon'  =>  '<i class="fas fa-file-invoice"></i>',
                    'url'   =>  'admin/pages',
                ],
                [
                    'title' =>  __('constant.MENUS'),
                    'icon'  =>  '<i class="fas fa-bars"></i>',
                    'url'   =>  'admin/menu',
                ],
                [
                    'title' =>  __('constant.EMAIL_TEMPLATE'),
                    'icon'  =>  '<i class="fas fa-envelope"></i>',
                    'url'   =>  'admin/email-template',
                ],
            ],
        ],
    ];

    $sidebar = json_decode(json_encode($sidebar));
    //dd($sidebar);
    function hasChildUrl($url, $sub_menu)
    {
        foreach($sub_menu as $value)
        {
            if(strpos($url, $value->url)!==false)
            {
                return true;
            }
        }
        return false;
    }
@endphp

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('admin/home') }}">{{ config('app.name') }} Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('admin/home') }}">{{ config('app.name') }}</a>
        </div>
        <ul class="sidebar-menu">
            @if($sidebar)
            @foreach ($sidebar as $item)
            <li class="menu-header">{{ $item->menu_header }}</li>
            @foreach ($item->main_menu as $mainitem)
            <li class="dropdown @if(Arr::has($mainitem, 'sub_menu') && hasChildUrl(url()->current(), $mainitem->sub_menu)!==false)  active @elseif(Str::contains(url()->current(), $mainitem->url)!==false) active @endif">
                <a href="{{ url($mainitem->url) }}" class="@if(Arr::has($mainitem, 'sub_menu')) has-dropdown @endif nav-link">{!! $mainitem->icon !!}<span>{{ $mainitem->title }}</span></a>
                @if(Arr::has($mainitem, 'sub_menu'))
                <ul class="dropdown-menu"@if(hasChildUrl(url()->current(), $mainitem->sub_menu)!==false) style="display:block;" @endif>
                    @if($mainitem->sub_menu)
                    @foreach ($mainitem->sub_menu as $subitem)
                    <li @if(Str::contains(url()->current(), $subitem->url)!==false) class="active" @endif><a href="{{ url($subitem->url) }}" class="nav-link">{{ $subitem->title }}</a></li>
                    @endforeach
                    @endif
                </ul>
                @endif
            </li>
            @endforeach
            @endforeach
            @endif
        </ul>
    </aside>
</div>
