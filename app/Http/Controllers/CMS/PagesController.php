<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Page;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.PAGES');
        $this->module = 'PAGES';
        $this->middleware('grant.permission:'.$this->module);
        $this->pagination = $this->systemSetting()->pagination ?? config('system_settings.pagination');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = $this->title;
        $pages = Page::orderBy('view_order', 'asc')->get();

        return view('admin.cms.pages.index', compact('title', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $pages = Page::orderBy('title', 'asc')->get();

        return view('admin.cms.pages.create', compact('title', 'pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'  =>  'required',
            'slug'   =>  'required|unique:pages,slug',
            'parent'  =>  'required',
            'view_order'   =>  'required|numeric',
            'status'   =>  'required',
        ]);

        $pages = new Page;
        $pages->title = $request->title;
        $pages->slug = $request->slug;
        $pages->parent = $request->parent;
        $pages->content = $request->content;
        $pages->view_order = $request->view_order;
        $pages->new_tab = $request->new_tab ?? 0;
        $pages->status = $request->status;
        $pages->save();

        return redirect()->route('pages.index')->with('success',  __('constant.CREATED', ['module'    =>  $this->title]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = $this->title;
        $page = Page::findorfail($id);
        $pages = Page::all();

        return view('admin.cms.pages.show', compact('title', 'page', 'pages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = $this->title;
        $page = Page::findorfail($id);
        $pages = Page::whereNotIn('id', [$id])->orderBy('title', 'asc')->get();

        return view('admin.cms.pages.edit', compact('title', 'page', 'pages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'  =>  'required',
            'slug'   =>  'required|unique:pages,slug,'.$id.',id',
            'parent'  =>  'required',
            'view_order'   =>  'required|numeric',
            'status'   =>  'required',
        ]);

        $pages = Page::findorfail($id);
        $pages->title = $request->title;
        $pages->slug = $request->slug;
        $pages->parent = $request->parent;
        $pages->content = $request->content;
        $pages->view_order = $request->view_order;
        $pages->new_tab = $request->new_tab ?? 0;
        $pages->status = $request->status;
        $pages->updated_at = Carbon::now();
        $pages->save();

        return redirect()->route('pages.index')->with('success',  __('constant.UPDATED', ['module'    =>  $this->title]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $id = explode(',', $request->multiple_delete);
        Page::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }

    public function search(Request $request)
    {
        $title = $this->title;
        $search = $request->search;
        $pages = Page::search($search)->orderBy('view_order', 'asc')->paginate($this->systemSetting()->pagination);

        return view('admin.cms.pages.index', compact('title', 'pages'));
    }
}
