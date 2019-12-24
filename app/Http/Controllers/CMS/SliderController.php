<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Page;
use App\Slider;
use App\Traits\SystemSettingTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    use SystemSettingTrait;

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->title = __('constant.SLIDER');
        $this->module = 'SLIDER';
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
        $pages = Page::where('slug', 'home')->get();
        $slider = Slider::orderBy('created_at', 'desc')->paginate($this->pagination);

        return view('admin.cms.slider.index', compact('title', 'slider', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = $this->title;
        $pages = Page::where('slug', 'home')->get();
        return view('admin.cms.slider.create', compact('title', 'pages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->session()->flash('slider_data', $request->only('view_order', 'caption'));

        $messages = [
            'slider_images.*.required'    =>  'The slider images field is required.',
            'slider_images.*.mimes'    =>  'The slider images must be a file of type: jpg, png, gif, jpeg.',
            'slider_images.*.max'    =>  'The slider images may not be greater than 25mb.',
            'caption.*.required'    =>  'The caption field is required.',
            'view_order.*.required'    =>  'The view order field is required.',
        ];

        $request->validate([
            'page_id' =>  'required',
            'caption.*'    =>  'required',
            'slider_images.*'  =>  'required|file|mimes:jpg,png,gif,jpeg|max:25000',
            'view_order.*'    =>  'required',
            'position'  =>  'required',
            'status' =>  'required',
        ], $messages);

        $slider = new Slider;
        $slider->page_id = $request->page_id;
        $slider_images_array = [];
        for($i=0;$i<count($request->view_order);$i++)
        {
            if ($request->hasFile('slider_images.'.$i)) {
                $slider_images = $request->file('slider_images.'.$i);
                $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $slider_images->getClientOriginalName();
                $filepath = 'storage/slider/';
                Storage::putFileAs(
                    'public/slider', $slider_images, $filename
                );
                $path_slider_images = $filepath . $filename;
                $slider_images_array[] = [
                    'slider_image'  =>  $path_slider_images,
                    'view_order'    =>  $request->view_order[$i],
                    'caption'   =>  $request->caption[$i],
                ];
            }
        }
        $slider->slider_images = json_encode($slider_images_array);
        $slider->position = $request->position;
        $slider->status = $request->status;
        $slider->save();

        return redirect()->route('slider.index')->with('success', __('constant.CREATED', ['module' => $this->title]));
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
        $pages = Page::where('slug', 'home')->get();
        $slider = Slider::find($id);

        return view('admin.cms.slider.show', compact('title', 'slider', 'pages'));
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
        $pages = Page::where('slug', 'home')->get();
        $slider = Slider::find($id);

        return view('admin.cms.slider.edit', compact('title', 'slider', 'pages'));
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
        $request->session()->flash('slider_data', $request->only('view_order'));

        $request->validate([
            'page_id' =>  'required',
            'slider_images.*'  =>  'required|file|mimes:jpg,png,gif,jpeg|max:25000',
            'view_order.*'    =>  'required',
            'position'  =>  'required',
            'status' =>  'required',
        ]);

        $slider = Slider::find($id);
        $slider->page_id = $request->page_id;
        $slider_images_array = [];
        for($i=0;$i<count($request->view_order);$i++)
        {
            if ($request->hasFile('slider_images.'.$i)) {
                $slider_images = $request->file('slider_images.'.$i);
                $filename = Carbon::now()->format('Y-m-d H-i-s') . '__' . guid() . '__' . $slider_images->getClientOriginalName();
                $filepath = 'storage/slider/';
                Storage::putFileAs(
                    'public/slider', $slider_images, $filename
                );
                $path_slider_images = $filepath . $filename;
                $slider_images_array[] = [
                    'slider_image'  =>  $path_slider_images,
                    'view_order'    =>  $request->view_order[$i],
                    'caption'   =>  $request->caption[$i],
                ];
            }
            else
            {
                $slider_images_array[] = [
                    'slider_image'  =>  $request->slider_images_hidden[$i],
                    'view_order'    =>  $request->view_order[$i],
                    'caption'   =>  $request->caption[$i],
                ];
            }
        }
        $slider->slider_images = json_encode($slider_images_array);
        $slider->position = $request->position;
        $slider->status = $request->status;
        $slider->save();

        return redirect()->route('slider.index')->with('success', __('constant.UPDATED', ['module' => $this->title]));
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
        Slider::destroy($id);

        return redirect()->back()->with('success',  __('constant.DELETED', ['module'    =>  $this->title]));
    }
}
