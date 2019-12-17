<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\DB;

class Page extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;

    public function scopeSearch($query, $search_term)
    {
        $query->where('pages.title', 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(pages.created_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        $query->orwhere(DB::raw("(DATE_FORMAT(pages.updated_at,'%d %b, %Y %h:%i %p'))"), 'like', '%'.$search_term.'%');
        return $query;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('view_order', 'asc');
    }
}
