<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DashUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function login()
    {
        if (Auth::guard('admin')->check()) return redirect()->route('adminHome');
        $data['username'] = '';
        $data['first'] = true;
        return view('auth/login', $data);
    }

    public function authenticate(Request $request)
    {
        if (Auth::guard('admin')->check()) return  redirect()->route('adminHome');

        $request->validate([
            "userName"  => "required",
            "passWord"  => "required"
        ]);

        $data['first'] = true;

        if (Auth::guard('admin')->attempt(array('DASH_USNM' => $request->userName, 'password' => $request->passWord), true)) {
            return redirect()->route('adminHome');
        } else {
            $data['first'] = false;
            return view('auth/login', $data);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::guard("admin")->check()) {
            //Totals by Sub category
            $data['catgGraphs'] =  [
                ['color' => "info", "name" => "Men"],
                ['color' => "success", "name" => "Women"],
            ];
            $data['catgTotals'] =  [
                ["name" => "Shorts", "value" => "100", "unit" => "EGP"],
                ["name" => "T-Shirts", "value" => "200", "unit" => "EGP"],
            ];
            $data['catgCardTitle'] =  "Total Sales By Subcategories";
            $data['catgTitle'] =  "Totals Sales";
            $data['catgSubtitle'] =  "Check total money recieved for each subcategory";

            //Totals Sales
            $data['totalGraphs'] =  [];
            $data['totalTotals'] =  [];
            $data['totalCardTitle'] =  "Total Revenue";
            $data['totalTitle'] =  "Overall Sales Total";
            $data['totalSubtitle'] =  "Check total money recieved and number of items sold";

            //Total Sales
            return view('home', $data);
        } else return redirect("login");
    }

    public function logout()
    {
        Auth::guard("admin")->logout();
        return redirect("login");
    }
}
