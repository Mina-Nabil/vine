<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    protected $data;
    protected $homeURL = 'admin/categories/show';

    private function initDataArr()
    {
        $this->data['items'] = SubCategory::all();
        $this->data['categories'] = Category::all();
        $this->data['title'] = "Products Types";
        $this->data['subTitle'] = "Manage Categories and Sub-Categories";
        $this->data['cols'] = ['Category', 'Sub Category', 'Edit'];
        $this->data['atts'] = [
            ['foreignUrl' => ['admin/categories/edit', 'category_id', 'category', 'name']],
            ['dynamicUrl' => ['admin/products/show/catg/sub/', 'val' => 'id', 'att' => 'name']],
            ['edit' => ['url' => 'admin/subcategories/edit/', 'att' => 'id']]
        ];
        $this->data['homeURL'] = $this->homeURL;
    }

    public function home()
    {
        $this->initDataArr();
        $this->data['formTitle'] = "Add Sub Category";
        $this->data['formURL'] = "admin/subcategories/insert";
        $this->data['isCancel'] = false;
        $this->data['form2Title'] = "Add Main Category";
        $this->data['form2URL'] = "admin/categories/insert";
        $this->data['isCancel2'] = false;
        return view('products.categories', $this->data);
    }

    public function editSubCategory($id)
    {
        $this->initDataArr();
        $this->data['subcategory'] = SubCategory::findOrFail($id);
        $this->data['formTitle'] = "Manage SubCategory (" . $this->data['subcategory']->name . ")";
        $this->data['formURL'] = "admin/subcategories/update";
        $this->data['isCancel'] = true;
        $this->data['form2Title'] = "Add Main Categories";
        $this->data['form2URL'] = "admin/categories/insert";
        $this->data['isCancel2'] = false;
        return view('products.categories', $this->data);
    }

    public function editCategory($id)
    {
        $this->initDataArr();
        $this->data['category'] = Category::findOrFail($id);
        $this->data['formTitle'] = "Add Sub-Categories";
        $this->data['formURL'] = "admin/subcategories/insert";
        $this->data['isCancel'] = false;
        $this->data['form2Title'] = "Manage Category (" . $this->data['category']->name . ")";
        $this->data['form2URL'] = "admin/categories/update";
        $this->data['isCancel2'] = true;
        return view('products.categories', $this->data);
    }

    public function insertCategory(Request $request)
    {

        $request->validate([
            "catgName"      => "required|unique:categories,name",
            "arbcName"  => "required",
        ]);

        Category::newCategory($request->catgName, $request->arbcName);

        return redirect($this->homeURL);
    }
    public function insertSubCategory(Request $request)
    {

        $request->validate([
            "name"      =>      "required",
            "arbcName"  =>      "required",
            "category"  =>      "required",
            "photo"     =>      "required|image|max:15024" //15MB
        ]);

        SubCategory::createNew($request->name, $request->arbcName, $request->category, $request->photo, $request->desc);
        return redirect($this->homeURL);
    }



    public function updateSubCategory(Request $request)
    {
        $request->validate([
            "id" => "required",
        ]);

        /** @var SubCategory */
        $subcategory = SubCategory::findOrFail($request->id);

        $request->validate([
            "name" => ["required",  Rule::unique('sub_categories', "name")->ignore($subcategory->name, "name"),],
            "category" => "required",
            "arbcName" => "required",
            "id" => "required",
        ]);

        $subcategory->editInfo($request->name, $request->arbcName, $request->category, $request->photo, $request->desc);

        return redirect($this->homeURL);
    }


    public function updateCategory(Request $request)
    {
        $request->validate([
            "catgName" => "required",
            "arbcName" => "required",
            "id" => "required",
        ]);

        $category = Category::findOrFail($request->id);
        $category->editInfo($request->catgName, $request->arbcName);
        $category->save();

        return redirect($this->homeURL);
    }
}
