<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SizeChart;
use App\Models\SubCategory;
use App\Models\Tag;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{

    protected $data;
    protected $homeURL = "admin/products/show/all";
    protected $detailsURL = "admin/products/details/";

    ///////////////////Models Pages

    public function home($sub = -1)
    {
        $this->initTableArr(-1, $sub);
        return view("products.table", $this->data);
    }

    public function sale()
    {
        $this->initTableArr(-1, -1, 1);
        return view("products.table", $this->data);
    }

    public function new()
    {
        $this->initTableArr(-1, -1, -1, 1);
        return view("products.table", $this->data);
    }


    public function showCategory(Request $request)
    {
        $request->validate([
            "category" => 'required'
        ]);

        $this->initTableArr($request->category);
        return view("products.table", $this->data);
    }
    public function showSubCategory(Request $request)
    {
        $request->validate([
            "subcategory" => 'required'
        ]);
        $this->initTableArr(-1, $request->subcategory);
        return view("products.table", $this->data);
    }

    public function add()
    {
        $this->initAddArr();
        return view("products.add", $this->data);
    }

    public function edit($prodID)
    {
        $this->initAddArr($prodID);
        return view("products.add", $this->data);
    }

    public function filterCategory()
    {
        $this->data['categories'] = Category::all();
        $this->data['subcategories'] = SubCategory::all();

        $this->data['categoryURL'] = 'admin/products/category';
        $this->data['subcategoryURL'] = 'admin/products/subcategory';

        return view('products.filters.categories', $this->data);
    }

    ////////////////////////////////////Profile Functions//////////////////////////////////

    public function details($prodID)
    {
        $product = Product::with("mainImage", "images", "tags", "sizechart", "stock", "subcategory")->where("id", $prodID)->get()->first();
        //dd($product->sizes());

        $this->data['categories'] = SubCategory::with('category')->get();
        $this->data['formURL'] = "admin/products/update";
        $this->data['formTitle'] = "Edit Model Info";
        $this->data['isCancel'] = true;
        $this->data['homeURL'] = $this->homeURL;
        $this->data['deleteUrl'] = url('admin/products/delete/image/');


        $this->data['items'] = Inventory::with(["product", "color", "size"])->where("INVT_PROD_ID", "=", $prodID)->get();

        $this->data['title'] = "Items Available";
        $this->data['subTitle'] = "View Current Stock for (" . $product->PROD_NAME . ")";
        $this->data['cols'] = ['Color', 'Size', 'Count'];
        $this->data['atts'] = [
            // ['foreignUrl' => ['admin/roducts/profile', 'INVT_PROD_ID', 'product', 'PROD_NAME']],
            ['foreign' => ['color', 'COLR_NAME']],
            ['foreign' => ['size', 'SIZE_NAME']],
            'INVT_CUNT'
        ];

        $this->data['imageFormURL'] =   "producs/add/image/" . $product->id;
        $this->data['tagsFormURL'] =   "products/linktags/" . $product->id;
        $this->data['prodTagIDs'] = $product->tags->pluck('id')->all();

        $this->data['tags']       =   Tag::all();

        $this->data['product'] = $product;
        return view("products.details", $this->data);
    }

    public function attachImage($prodId, Request $request)
    {
        $product = Product::findOrFail($prodId);
        $request->validate([
            "photo" => "required|image|max:15048"
        ]);
        $product->addImage($request->photo, $request->color);

        return redirect('products/details/' . $prodId);
    }

    public function deleteImage($id){
        $prodImage = ProductImage::with('product')->findOrFail($id);
        $prodId = $prodImage->product->id;
        $prodImage->delete(); 
        return redirect('products/details/' . $prodId);
    }   

    public function setMainImage($prodID, $imageID)
    {
        $product = Product::findOrFail($prodID);
        $product->PROD_PIMG_ID = $imageID;
        $product->save();
        return redirect('products/details/' . $prodID);
    }

    public function setChartImage($prodID, Request $request)
    {
        $product = Product::findOrFail($prodID);
        $request->validate([
            'chart' => "required|exists:size_chart,id"
        ]);
        $product->PROD_SZCT_ID = $request->chart;
        $product->save();
        return redirect('products/details/' . $prodID);
    }

    public function unsetChartImage($prodID)
    {
        $product = Product::findOrFail($prodID);
        $product->PROD_SZCT_ID = NULL;
        $product->save();
        return redirect('products/details/' . $prodID);
    }

    public function linkTags($prodID, Request $request)
    {
        $product = Product::findOrFail($prodID);
        $product->tags()->sync($request->tags);
        return redirect('products/details/' . $prodID);
    }

    public function insert(Request $request)
    {
        $request->validate([
            "name" => "required|unique:products,PROD_NAME",
            "arbcName" => "required",
            "desc" => "required",
            "arbcDesc" => "required",
            "category" => "required|exists:sub_categories,id",
            "price" => "required|numeric",
            "cost" => "nullable|numeric",
        ]);

        $newProd = Product::create($request->name, $request->arbcName, $request->desc, $request->arbcDesc, $request->category, $request->price, $request->barCode, $request->cost, $request->offer);

        return redirect('products/details/' . $newProd->id);
    }

    ////////////////////////////////REST Function///////////////////////////

    public function update(Request $request)
    {
        $request->validate([
            "id"          => "required",
        ]);
        $product = Product::findOrFail($request->id);
        $request->validate([
            "name"          => ["required",  Rule::unique('products', "PROD_NAME")->ignore($product->PROD_NAME, "PROD_NAME"),],
            "arbcName" => "required",
            "category" => "required|exists:sub_categories,id",
            "price" => "required|numeric",
            "cost" => "nullable|numeric",
        ]);
        $product->modify($request->name, $request->arbcName, $request->desc, $request->arbcDesc, $request->category, $request->price, $request->barCode, $request->cost, $request->offer);

        return redirect('products/details/' . $product->id);
    }


    //////////////////Initializing Data Arrays
    private function initTableArr($category = -1, $subcategory = -1, $sale = -1, $newArrivals = -1)
    {
        if ($category != -1) {

            $this->data['items'] = Product::all();
            $category = Category::findOrFail($category);
            $this->data['title'] = $category->CATG_NAME . "'s Models";
            $this->data['subTitle'] = "Showing all Models for " . $category->CATG_NAME;
        } elseif ($subcategory != -1) {
            $this->data['items'] = Product::with('subcategory')->ofSubcategory($subcategory)->get();
            $subcategory = SubCategory::findOrFail($subcategory);
            $this->data['title'] = $subcategory->SBCT_NAME . "'s Models";
            $this->data['subTitle'] = "Showing all Models for " . $subcategory->SBCT_NAME;
        } else if ($sale != -1) {
            $this->data['items'] = Product::with('stock', 'subcategory')->where("PROD_OFFR", "<>", 0)->get();
            $this->data['title'] =  "On Sale";
            $this->data['subTitle'] = "Showing all Models currently on sale ";
        } else if ($newArrivals != -1) {
            $this->data['items'] = Product::newArrivals("P1M"); // 1 month
            $this->data['title'] =  "New Arrivals";
            $this->data['subTitle'] = "Showing Models Newly created during the last month ";
        } else {

            $this->data['items'] = Product::with('subcategory')->withCount('stock')->get();
            $this->data['title'] = "All Models";
            $this->data['subTitle'] = "Showing all Models";
        }
        $this->data['cols'] = ['Category', 'Model Title', 'Arabic Title', "in Stock", 'Price', 'Cost', 'Offer', 'Edit'];
        $this->data['atts'] = [
            ['foreignUrl' => ['admin/roducts/show/catg/sub', 'PROD_SBCT_ID', 'subcategory', 'name']],
            ['attUrl' => ['url' => 'admin/products/details', 'urlAtt' => "id", "shownAtt" => "PROD_NAME"]],
            ['attUrl' => ['url' => 'admin/products/details', 'urlAtt' => "id", "shownAtt" => "PROD_ARBC_NAME"]],
            (($newArrivals == -1) ? ['sumForeign' => ['rel' => "stock", "att" => "INVT_CUNT"]] : "stock"),
            'PROD_PRCE',
            'PROD_COST',
            'PROD_OFFR',
            ['edit' => ['url' => 'admin/products/edit/', 'att' => 'id']],
        ];
        // dd($this->data['items'][0]->stock_count);
        $this->data['homeURL'] = $this->homeURL;
    }

    private function initAddArr($prodID = -1)
    {
        if ($prodID != -1) {
            $this->data['product'] = Product::findOrFail($prodID);
            $this->data['formURL'] = "admin/products/update";
        } else {
            $this->data['formURL'] = "admin/products/insert/";
        }
        $this->data['categories'] = SubCategory::with('category')->get();
        $this->data['formTitle'] = "Add New Model";
        $this->data['isCancel'] = true;
        $this->data['homeURL'] = $this->homeURL;
    }
}
