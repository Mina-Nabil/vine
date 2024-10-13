<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AreasController extends Controller
{
    protected $data;
    protected $homeURL = 'admin/areas/show';

    private function initDataArr()
    {
        $this->data['items'] = Area::all();
        $this->data['title'] = "Covered Areas";
        $this->data['subTitle'] = "Manage all Covered Areas and their delivery rate";
        $this->data['cols'] = ['Area', 'Arabic Name', 'Rate', 'Active', 'Edit'];
        $this->data['atts'] = [
            'name', 'arabic_name', 'rate',
            [
                'toggle' => [
                    "att"   =>  "is_active",
                    "url"   =>  "admin/areas/toggle/",
                    "states" => [
                        "1" => "Active",
                        "0" => "Disabled",
                    ],
                    "actions" => [
                        "1" => "disable the Area",
                        "0" => "Activate the Area",
                    ],
                    "classes" => [
                        "1" => "label-info",
                        "0" => "label-danger",
                    ],
                ]
            ],
            ['edit' => ['url' => 'admin/areas/edit/', 'att' => 'id']],
        ];
        $this->data['homeURL'] = $this->homeURL;
    }

    public function home()
    {
        $this->initDataArr();
        $this->data['formTitle'] = "Add Area";
        $this->data['formURL'] = "admin/areas/insert";
        $this->data['isCancel'] = false;
        return view('settings.area', $this->data);
    }

    public function edit($id)
    {
        $this->initDataArr();
        $this->data['area'] = Area::findOrFail($id);
        $this->data['formTitle'] = "Edit Area ( " . $this->data['area']->name . " )";
        $this->data['formURL'] = "admin/areas/update";
        $this->data['isCancel'] = false;
        return view('settings.area', $this->data);
    }

    public function toggle($id)
    {

        $area = Area::findOrfail($id);
        if ($area->is_active) {
            $area->is_active = 0;
        } else {
            $area->is_active = 1;
        }
        $area->save();
        return redirect($this->homeURL);
    }

    public function insert(Request $request)
    {

        $request->validate([
            "name"      => "required|unique:areas,name",
            "arbcName"  => "required",
            "rate"  => "required|numeric",
        ]);

        Area::createArea($request->name, $request->arbcName, $request->rate);

        return redirect($this->homeURL);
    }

    public function update(Request $request)
    {
        $request->validate([
            "id" => "required",
        ]);
        /** @var Area */
        $area = Area::findOrFail($request->id);

        $request->validate([
            "name" => ["required",  Rule::unique('areas', "name")->ignore($area->name, "name"),],
            "arbcName" => "required",
            "rate"  => "required|numeric",
            "id" => "required",
        ]);
        $area->editInfo($request->name, $request->arbcName, $request->rate);

        return redirect($this->homeURL);
    }
}
