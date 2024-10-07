<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SizeChart;
use Illuminate\Http\Request;

class ChartsController extends Controller
{
    protected $data;
    protected $homeURL = 'charts/show';

    private function initDataArr()
    {
        $this->data['items'] = SizeChart::all();
        $this->data['title'] = "Size Chart Images";
        $this->data['subTitle'] = "Manage all Size Charts";
        $this->data['cols'] = ['Size Chart Name', 'Edit'];
        $this->data['atts'] = [
            ['fileUrl' => ["url" => "image_url" ,  'att'=>'SZCT_NAME']],
            ['edit' => ['url' => 'charts/edit/', 'att' => 'id']],
        ];
        $this->data['homeURL'] = $this->homeURL;
    }

    public function home()
    {
        $this->initDataArr();
        $this->data['formTitle'] = "Add Size Chart";
        $this->data['formURL'] = "charts/insert";
        $this->data['isCancel'] = false;
        return view('settings.charts', $this->data);
    }

    public function edit($id)
    {
        $this->initDataArr();
        $this->data['chart'] = SizeChart::findOrFail($id);
        $this->data['formTitle'] = "Edit Chart ( " . $this->data['chart']->SZCT_NAME . " )";
        $this->data['formURL'] = "charts/update";
        $this->data['isCancel'] = false;
        return view('settings.charts', $this->data);
    }

    public function insert(Request $request)
    {

        $request->validate([
            "name"      => "required",
            "image"     => "required|image|max:512",
        ]);

        SizeChart::create($request->name, $request->image);

        return redirect($this->homeURL);
    }

    public function update(Request $request)
    {
        $request->validate([
            "name"      => "required",
            "image"     => "nullable|image|max:512",
            "id"        => "required",
        ]);

        $chart = SizeChart::findOrFail($request->id);
        $chart->modify($request->name, $request->image);

        return redirect($this->homeURL);
    }
}
