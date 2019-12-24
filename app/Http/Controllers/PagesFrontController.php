<?php

namespace App\Http\Controllers;

use App\Advertiser;
use Illuminate\Http\Request;
use App\Page;
use App\Menu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use PDF;
class PagesFrontController extends Controller
{
   
    public function __construct()
    {


       /* $this->middleware('auth:web')->except(['index', 'pages', 'fetch_data', 'studentVerification', 'compare_scholarships','compare_store','compare']);



        $this->middleware(function ($request, $next) {
            $this->student_id = Auth::user()->student_id;
            $this->previous = url()->previous();
            return $next($request);

        })->except(['index', 'pages', 'fetch_data', 'studentVerification', 'compare_scholarships','compare_store','compare']);*/

    }


    public function index($slug = 'home')
    {
        
            $page=get_page_by_slug($slug);
			if(!$page)
			{
			 return abort(404);
			}
			return view('home',compact("page"));
        
    }

    public function pages($slug)
    {
        
        $page=get_page_by_slug($slug);
		if(!$page)
        {
		 return abort(404);
        }
		
        return view('pages', compact('page'));
		
    }
	public function profileUpdate(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'phone' => 'required|string',
			'organization' => 'required|string',
            'country'   =>  'required',
			'password'  =>  'nullable|min:6',
            'password_confirmation'  =>  'same:password',

        ]);

            $user = User::where('user_id', $id)->firstOrFail();

            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->organization = $request->organization;
            $user->telephone_number = $request->telephone_number;
            $user->phone = $request->phone;
            $user->country = $request->country;
			if($request->password)
            {
            $user->password = Hash::make($request->password);
            }
            $user->save();
            return redirect('profile')->with('success',  'Success! Profile have been updated.');


    }
	public function changePassword()
    {
        $slug_url = 'change-password';
        $menu = Menu::where('status', 1)->orderBy('view_order', 'asc')->get();
		$banner = Banner::where('status', 1)->orderBy('order_by', 'asc')->get();
        $page = Page::where('slug', $slug_url)->where('status', 1)->first();
		if(!Auth::check())
            {
                return redirect(url('login'));
            }
		if(!$page)
        {
		 return abort(404);
        }
		return view('auth.change-password', compact('page', 'menu', 'banner'));
    }

    public function changePasswordStore(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'old_password' => 'required',
            'password' =>  'required|min:8|confirmed',
        ]);

        $user = User::where('user_id', Auth::user()->user_id)->first();
        $user->password = Hash::make($request->password);
        $user->updated_at = Carbon::now();
        $user->save();

        return redirect(url('profile/change-password'))->with('success', 'Password has been updated.');
    }

	

}
