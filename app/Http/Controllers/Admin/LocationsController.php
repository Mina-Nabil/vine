<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Services\FileManager;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationsController extends Controller
{
    protected $data;
    protected $homeURL = 'admin/locations/show';

    private function initDataArr()
    {
        $this->data['items'] = Location::all();
        $this->data['title'] = "Locations";
        $this->data['subTitle'] = "Manage all locations and their details";
        $this->data['cols'] = ['Title', 'Location URL', 'Active', 'Edit'];
        $this->data['atts'] = [
            'title', 'location_url',
            [
                'toggle' => [
                    "att"   =>  "is_active",
                    "url"   =>  "admin/locations/toggle/",
                    "states" => [
                        "1" => "Active",
                        "0" => "Disabled",
                    ],
                    "actions" => [
                        "1" => "disable the Location",
                        "0" => "Activate the Location",
                    ],
                    "classes" => [
                        "1" => "label-info",
                        "0" => "label-danger",
                    ],
                ]
            ],
            ['edit' => ['url' => 'admin/locations/edit/', 'att' => 'id']],
        ];
        $this->data['homeURL'] = $this->homeURL;
    }

    public function home()
    {
        $this->initDataArr();
        $this->data['formTitle'] = "Add Location";
        $this->data['formURL'] = "admin/locations/insert";
        $this->data['isCancel'] = false;
        return view('settings.location', $this->data);
    }

    public function edit($id)
    {
        $this->initDataArr();
        $this->data['location'] = Location::findOrFail($id);
        $this->data['formTitle'] = "Edit Location ( " . $this->data['location']->title . " )";
        $this->data['formURL'] = "admin/locations/update";
        $this->data['isCancel'] = false;
        return view('settings.location', $this->data);
    }

    public function toggle($id)
    {
        $location = Location::findOrfail($id);
        if ($location->is_active) {
            $location->is_active = 0;
        } else {
            $location->is_active = 1;
        }
        $location->save();
        return redirect($this->homeURL);
    }

    public function insert(Request $request)
    {
        $request->validate([
            "photo"          => "required|image|mimes:jpeg,png,jpg,gif|max:3072",
            "title"          => "required|unique:locations,title",
            "location_url"   => "required|url",
            "address"        => "nullable|string",
            "telephone"      => "nullable|string",
        ]);

        $imagePath = FileManager::save($request->file('photo'), 'locations');

        Location::createLocation(
            $imagePath,
            $request->title,
            $request->location_url,
            $request->address,
            $request->telephone
        );

        return redirect($this->homeURL);
    }

    public function update(Request $request)
    {
        $request->validate([
            "id" => "required",
        ]);
        
        /** @var Location */
        $location = Location::findOrFail($request->id);

        $validationRules = [
            "title" => ["required",  Rule::unique('locations', "title")->ignore($location->title, "title"),],
            "location_url"   => "required|url",
            "address"        => "nullable|string",
            "telephone"      => "nullable|string",
            "id" => "required",
        ];

        // If a new photo is uploaded, validate it
        if ($request->hasFile('photo')) {
            $validationRules["photo"] = "required|image|mimes:jpeg,png,jpg,gif|max:3072";
        }

        $request->validate($validationRules);
        
        $imagePath = $location->image_url; // Keep existing image by default
        
        // If new photo is uploaded, store it
        if ($request->hasFile('photo')) {
            // Delete old image if it exists
            if ($location->image_url) {
                FileManager::delete($location->attributes['image_url']);
            }
            $imagePath = FileManager::save($request->file('photo'), 'locations');
        }
        
        $location->editInfo(
            $imagePath,
            $request->title,
            $request->location_url,
            $request->address,
            $request->telephone
        );

        return redirect($this->homeURL);
    }
}
