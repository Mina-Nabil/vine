<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SizesController extends Controller
{
    protected $data;
    protected $homeURL = 'sizes/show';

    private function initDataArr()
    {
        $this->data['items'] = Size::all();
        $this->data['title'] = "Available Sizes";
        $this->data['subTitle'] = "Manage all Available Sizes";
        $this->data['cols'] = ['Size', 'Arabic Name', 'Code', 'Edit'];
        $this->data['atts'] = [
            'SIZE_NAME', 'SIZE_ARBC_NAME', 'SIZE_CODE',
            ['edit' => ['url' => 'sizes/edit/', 'att' => 'id']],
        ];
        $this->data['homeURL'] = $this->homeURL;
    }

    public function home()
    {
        $this->initDataArr();
        $this->data['formTitle'] = "Add Size";
        $this->data['formURL'] = "sizes/insert";
        $this->data['isCancel'] = false;
        return view('settings.sizes', $this->data);
    }

    public function edit($id)
    {
        $this->initDataArr();
        $this->data['size'] = Size::findOrFail($id);
        $this->data['formTitle'] = "Edit Size ( " . $this->data['size']->SIZE_NAME . " )";
        $this->data['formURL'] = "sizes/update";
        $this->data['isCancel'] = false;
        return view('settings.sizes', $this->data);
    }

    public function insert(Request $request)
    {

        $request->validate([
            "name"      => "required|unique:sizes,SIZE_NAME",
            "code"      => "required|unique:sizes,SIZE_CODE",
        ]);

        $size = Size::create($request->name, $request->arbcName, $request->code);

        return redirect($this->homeURL);
    }

    public function update(Request $request)
    {
        $request->validate([
            "id" => "required",
        ]);
        $size = Size::findOrFail($request->id);

        $request->validate([
            "name" => ["required",  Rule::unique('sizes', "SIZE_NAME")->ignore($size->SIZE_NAME, "SIZE_NAME"),],
            "code"      => ["required",  Rule::unique('sizes', "SIZE_CODE")->ignore($size->SIZE_CODE, "SIZE_CODE"),],
            "id"        => "required",
        ]);

        $size->modify($request->name, $request->arbcName, $request->code);

        return redirect($this->homeURL);
    }
}
