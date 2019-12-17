<?php

use Yadahan\AuthenticationLog\AuthenticationLog;

if (!function_exists('getPageList')) {

    /**
     * description
     *
     * @param
     * @return
     */
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
}
