<?php

use App\PermissionAccess;
use Yadahan\AuthenticationLog\AuthenticationLog;
use App\Page;
use App\Slider;
use App\Banner;
use App\Menu;
use App\MenuList;
use App\Role;

if (!function_exists('getPageList')) {

    /**
     * description
     *
     * @param
     * @return
     */

    function guid()
    {
        return uniqid();
    }

    function getPageList($array, $parent_id = 0, $indent = 0)
    {
        $data = '';
        if ($array) {
            foreach ($array as $key => $value) {
                if ($value['parent'] == $parent_id) {
                    $status_icon = '<div class="badge badge-danger">Inactive</div>';
                    if ($value['status'] == 1) {
                        $status_icon = '<div class="badge badge-success">Active</div>';
                    }
                    $data .= '<tr>';
                    $data .= '<td scope="row"><div class="custom-checkbox custom-control"> <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-' . ($key + 1) . '" value="' . $value['id'] . '"> <label for="checkbox-' . ($key + 1) . '" class="custom-control-label">&nbsp;</label></div></td>';
                    $data .= '<td>';
                    $data .= '<a href="' . route('pages.show', $value['id']) . '" class="btn btn-info mr-1 mt-1" data-toggle="tooltip" data-original-title="View"><i class="fas fa-eye"></i></a>';
                    $data .= '<a href="' . route('pages.edit', $value['id']) . '" class="btn btn-light mr-1 mt-1" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-edit"></i></a>';
                    $data .= '</td>';
                    $data .= '<td>';
                    $data .= str_repeat('<i class="fas fa-minus"></i> &nbsp;', $indent);
                    $data .= $value['title'] . '</td>';
                    $data .= '<td>' . $value['view_order'] . '</td>';
                    $data .= '<td>' . $status_icon . '</td>';
                    $data .= '<td>' . date('d M, Y h:i A', strtotime($value['created_at'])) . '</td>';
                    $data .= '<td>' . date('d M, Y h:i A', strtotime($value['updated_at'])) . '</td>';
                    $data .= '</tr>';
                    $data .= getPageList($array, $value['id'], $indent + 1);
                }
            }
        }
        return $data;
    }

    function getDropdownPageList($array, $parent_page_id, $parent_id = 0, $indent = 0)
    {
        $data = '';
        if ($array) {
            foreach ($array as $key => $value) {
                if ($value['parent'] == $parent_id) {
                    $selected = '';
                    if ($parent_page_id == $value['id']) {
                        $selected = 'selected';
                    }
                    $data .= '<option  value="' . $value['id'] . '" ' . $selected . '>';
                    $data .= str_repeat('__ &nbsp;', $indent);
                    $data .= $value['title'] . '</option>';
                    $data .= getDropdownPageList($array, $parent_page_id, $value['id'], $indent + 1);
                }
            }
        }
        return $data;
    }

    function getChildPage($array, $page_id, $indent = 0)
    {
        $data = '';
        if ($array) {
            foreach ($array as $key => $value) {
                if ($value['id'] == $page_id) {
                    $parent_icon = str_repeat('&nbsp; <i class="fas fa-chevron-right"></i> &nbsp;', $indent);
                    $data .= getChildPage($array, $value['parent'], $indent = 1);
                    $data .= $value['title'] . $parent_icon;
                }
            }
        }
        return $data;
    }

    function getActiveStatus($id = null)
    {
        $array_list = ['1'  =>  'Active', '2'  =>  'Inactive'];
        if ($id) {
            return $array_list[$id];
        }
        return $array_list;
    }

    function getCauserIp($causer_id)
    {
        if ($causer_id) {
            $result = AuthenticationLog::where('authenticatable_id', $causer_id)->first();
            if ($result) {
                return $result->ip_address;
            }
        }
        return '-';
    }

    function getActivePage($array, $page_id)
    {
        if ($array) {
            $result = $array->where('id', $page_id)->first();
            if ($result) {
                return $result->title;
            }
        }
    }

    function getModules($module = null)
    {
        $array_list = ['ACTIVITYLOG', 'MENU', 'MENU_LIST', 'PAGES', 'EMAIL_TEMPLATE', 'SYSTEM_SETTING', 'ROLES_AND_PERMISSION', 'BANNER', 'SLIDER', 'USER_ACCOUNT'];
        return $array_list;
    }

    function getPosition($id = null)
    {
        // $array_list = ['1'  =>  'Top', '2'  =>  'Right',    '3' =>  'Bottom', '4'   =>  'Left'];
        $array_list = ['1'  =>  'Top'];
        if($id)
        {
            return $array_list[$id];
        }
        return $array_list;
    }

    function get_permission_access_value($type, $module, $value, $role_id = null)
    {
        $permission_access = PermissionAccess::where(['role_id' => $role_id, $type => $value, 'module' => $module])->get();
        if ($permission_access->count()) {
            return 'checked';
        }
    }

    function is_permission_allowed($admin_id, $role_id, $module, $type)
    {
        if($admin_id==1)
        {
            return false;
        }
        $query = PermissionAccess::join('admins', 'permission_accesses.role_id', '=', 'admins.admin_role');
        if($role_id)
        {
            $query->where('admins.id', $admin_id);
            $query->where('permission_accesses.role_id', $role_id);
            $query->where('permission_accesses.'.$type, 1);
            $query->where('permission_accesses.module', $module);
        }
        $permission_access = $query->get();
        if (!$permission_access->count()) {
            abort(redirect()->route('access-not-allowed'));
        }
    }

    function getRoleName($role_id)
    {
        $result = Role::find($role_id);
        if($result)
        {
            return $result->name;
        }
        return '-';
    }

    function getMenuName($menu)
    {
        $result = Menu::find($menu);
        if($result)
        {
            return $result->title;
        }
    }

	function get_parent_menu($position = NULL,$page_id)
    {
        $string = [];
        $menus = MenuList::where('menu_lists.menu_id', $position)
			->where('menu_lists.status', 1)
            ->select('menu_lists.*')
            ->orderBy('view_order', 'asc')
            ->get();

        if ($menus->count() > 0) {
            //$string[] = '<ul>';
            foreach ($menus as $menu) {
                $link = create_menu_link($menu);
                if ($menu->page_id == NULL)
                    $target = 'target="_blank"';
                else
                    $target = "";


                if ($page_id == $menu->page_id)
                    $sel = 'class="active"';
                else
                    $sel = '';

				$string[] = '<li ' . $sel . '><a ' . $target . ' href="' . $link . '">' . $menu->title . '</a>';


                $string[] = '</li>';


            }
            //$string[] = '</ul>';
        }

        return join("", $string);
    }


	function create_menu_link($item = [])
    {

        if ($item['page_id'] == NULL) {
            return $item->external_link;
        } else {
            $page = Page::where('id', $item['page_id'])->select('pages.slug')->first();
            return url($page['slug']);
        }
    }

	function get_page_by_slug($slug=NULL)
	{
	  $page = Page::where('slug', $slug)->where('status', 1)->first();
	  if($page)
	  return $page;
	  else
	  return "";
	}


	function get_sliders()
	{
	  $slider = Slider::where('page_id', 1)->where('status', 1)->first();
	  if($slider)
	  return $slider;
	  else
	  return "";
	}

	function get_banner_by_page($page_id)
	{
	  $banner = Banner::where('page_id', $page_id)->where('status', 1)->inRandomOrder()->first();
	  if($banner)
	  return $banner;
	  else
	  return "";
	}


}
