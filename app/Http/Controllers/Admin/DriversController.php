<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DriversController extends Controller
{
    protected $data;
    protected $homeURL = 'admin/drivers/show';

    private function initDataArr()
    {
        $this->data['items'] = Driver::all();
        $this->data['title'] = "Registered Drivers";
        $this->data['subTitle'] = "Manage all Covered Drivers and their delivery rate";
        $this->data['cols'] = ['Driver', 'Mobile#', 'National ID', 'Active', 'Edit'];
        $this->data['atts'] = [
            'name', 'mobn', 'nationalID',
            [
                'toggle' => [
                    "att"   =>  "is_active",
                    "url"   =>  "admin/drivers/toggle/",
                    "states" => [
                        "1" => "Active",
                        "0" => "Disabled",
                    ],
                    "actions" => [
                        "1" => "disable the Driver",
                        "0" => "Activate the Driver",
                    ],
                    "classes" => [
                        "1" => "label-info",
                        "0" => "label-danger",
                    ],
                ]
            ],
            ['edit' => ['url' => 'admin/drivers/edit/', 'att' => 'id']],
        ];
        $this->data['homeURL'] = $this->homeURL;
    }
    
    public function home()
    {
        $this->initDataArr();
        $this->data['formTitle'] = "Add Driver";
        $this->data['formURL'] = "admin/drivers/insert";
        $this->data['isCancel'] = false;
        return view('settings.drivers', $this->data);
    }

    public function edit($id)
    {
        $this->initDataArr();
        $this->data['driver'] = Driver::findOrFail($id);
        $this->data['formTitle'] = "Edit Driver ( " . $this->data['driver']->name . " )";
        $this->data['formURL'] = "admin/drivers/update";
        $this->data['isCancel'] = false;
        return view('settings.drivers', $this->data);
    }

    public function toggle($id)
    {

        $driver = Driver::findOrfail($id);
        if ($driver->is_active) {
            $driver->is_active = 0;
        } else {
            $driver->is_active = 1;
        }
        $driver->save();
        return redirect($this->homeURL);
    }

    public function insert(Request $request)
    {

        $request->validate([
            "name"  => "required",
            "mob"   =>   "nullable",
            "nationalID"  => "nullable",
        ]);

        $driver = new Driver();
        $driver->name = $request->name;
        $driver->mobn = $request->mob;
        $driver->nationalID = $request->nationalID;
        $driver->save();
        return redirect($this->homeURL);
    }

    public function update(Request $request)
    {
        $request->validate([
            "id" => "required",
        ]);
        $driver = Driver::findOrFail($request->id);

        $request->validate([
            "name" => "required",
            "mob" => "nullable",
            "nationalID"  => "nullable",
            "id" => "required",
        ]);

        $driver->name = $request->name;
        $driver->mobn = $request->mob;
        $driver->nationalID = $request->nationalID;
        $driver->save();

        return redirect($this->homeURL);
    }
}
