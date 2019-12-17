<?php

// ADMIN DASHBOARD
Breadcrumbs::for('admin_home', function ($trail) {
    $trail->push(__('constant.DASHBOARD'), url('admin/home'));
});

// ACTIVITYLOG
Breadcrumbs::for('admin_activitylog', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.ACTIVITYLOG'), route('activitylog.index'));
});

// PROFILE
Breadcrumbs::for('admin_profile', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.PROFILE'), route('admin.profile'));
});

// SYSTEM SETTINGS
Breadcrumbs::for('system_settings', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.SYSTEM_SETTING'), route('admin.system-settings'));
});

// PAGES
Breadcrumbs::for('admin_pages', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.PAGES'), route('pages.index'));
});

Breadcrumbs::for('admin_pages_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_pages');
    $trail->push($title, $url);
});

// MENU
Breadcrumbs::for('admin_menu', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.MENU'), route('menu.index'));
});

Breadcrumbs::for('admin_menu_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_menu');
    $trail->push($title, $url);
});

// MENU LIST
Breadcrumbs::for('admin_menu_list', function ($trail, $menu) {
    $trail->parent('admin_menu', $menu);
    $trail->push(__('constant.MENU_LIST'), route('menu-list.index', $menu));
});

Breadcrumbs::for('admin_menu_list_crud', function ($trail, $menu, $title, $url = '#') {
    $trail->parent('admin_menu_list', $menu);
    $trail->push($title, $url);
});

// EMAIL TEMPLATE
Breadcrumbs::for('admin_email_template', function ($trail) {
    $trail->parent('admin_home');
    $trail->push(__('constant.EMAIL_TEMPLATE'), route('email-template.index'));
});

Breadcrumbs::for('admin_email_template_crud', function ($trail, $title, $url = '#') {
    $trail->parent('admin_email_template');
    $trail->push($title, $url);
});
