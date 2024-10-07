<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DashType;
use App\Models\DashUser;
use Illuminate\Http\Request;

class DashUsersController extends Controller
{
    protected $data;
    //init page data

    private function initDataArr()
    {
        $this->data['items'] = DashUser::with('dash_types')->get();
        $this->data['types'] = DashType::all();
        $this->data['title'] = "Dashboard Users";
        $this->data['subTitle'] = "Manage All Dashboard Users";
        $this->data['cols'] = ['Username', 'Fullname', 'Type', 'Edit'];
        $this->data['atts'] = ['DASH_USNM', 'DASH_FLNM', ['foreign' => ['dash_types', 'DHTP_NAME']], ['edit' => ['url' => 'dash/users/edit/', 'att' => 'id']]];
        $this->data['homeURL'] = 'dash/users/all';
    }

    public function index()
    {

        $this->initDataArr();
        $this->data['formTitle'] = "Add Admins";
        $this->data['isPassNeeded'] = true;
        $this->data['formURL'] = "dash/users/insert";
        $this->data['isCancel'] = false;
        return view("auth.dashusers", $this->data);
    }

    public function edit($id)
    {
        $this->initDataArr();
        $this->data['user'] = DashUser::findOrFail($id);
        $this->data['formTitle'] = "Manage Admin(" . $this->data['user']->DASH_USNM . ')';
        $this->data['isPassNeeded'] = false;
        $this->data['formURL'] = "dash/users/update";
        $this->data['isCancel'] = true;
        return view("auth.dashusers", $this->data);
    }

    public function insert(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'fullname' => "required",
            'type' => 'required',
            'password' => 'required',
            'photo' => 'nullable|image|max:1024',
        ]);

        DashUser::create($request->name, $request->fullname, $request->password, $request->type, $request->photo);

        return redirect("dash/users/all");
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'fullname' => "required",
            'type' => 'required',
            'photo' => 'nullable|image|max:1024',
        ]);

        $dashUser = DashUser::findOrFail($request->id);

        $dashUser->modify($request->name, $request->fullname, $request->password, $request->type, $request->photo);

        return redirect("dash/users/all");
    }
}
