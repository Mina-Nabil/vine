<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Gender;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    protected $data;
    protected $homeURL = "admin/users/show/all";


    private function initHomeArr($type = -1) // 0 all - 1 latest - 2 top
    {

        $this->data['title'] = "All Registered Clients";
        $this->data['type'] = $type;
        if ($type == 1)
            $this->data['items'] = User::latest()->limit(100)->get();
        else
            $this->data['items'] = User::latest()->get();

        $this->data['subTitle'] = "Manage Clients";
        $this->data['cols'] = ['id', 'Full Name', 'Mob#', 'Gender', 'Area', 'Since', 'Edit'];
        $this->data['atts'] = [
            'id',
            ['attUrl' => ["url" => 'admin/users/profile', "urlAtt" => 'id', "shownAtt" =>  "name"]],
            'mobile',
            ['foreign' => ['gender', 'name']],
            ['foreign' => ['area', 'name']],
            // ['sumForeign' => ['rel' => 'orders', 'att' => 'total']],
            ['date' => ['att' => 'created_at', 'format' => 'Y-M-d']],
            ['edit' => ['url' => 'admin/users/edit/', 'att' => 'id']]
        ];
        $this->data['homeURL'] = $this->homeURL;
    }

    private function initAddArr($userID = -1)
    {
        if ($userID != -1) {
            $this->data['user'] = User::findOrFail($userID);
            $this->data['formURL'] = "admin/users/update";
        } else {
            $this->data['formURL'] = "admin/users/insert/";
        }
        $this->data['genders'] = Gender::all();
        $this->data['areas']  = Area::active()->get();
        $this->data['formTitle'] = "Add New User";
        $this->data['isCancel'] = true;
        $this->data['homeURL'] = $this->homeURL;
    }

    private function initProfileArr($id)
    {
        $this->data['user'] = User::with("wishlist")->findOrFail($id);
        $this->data['userMoney'] = $this->data['user']->moneyPaid();
        $this->data['formURL'] = "admin/users/update";
        $this->data['genders'] = Gender::all();
        $this->data['areas']  = Area::active()->get();

        //Orders Array
        $this->data['orderList']    = Order::getOrdersByUser($id);
        $this->data['cardTitle'] = false;
        $this->data['ordersCols'] = ['id', 'Status', 'Payment',  'Items', 'Ordered On', 'Total'];
        $this->data['orderAtts'] = [
            ['attUrl' => ['url' => "admin/orders/details", "shownAtt" => 'id', "urlAtt" => 'id']],
            [
                'stateQuery' => [
                    "classes" => [
                        "1" => "label-info",
                        "2" => "label-warning",
                        "3" =>  "label-dark bg-dark",
                        "4" =>  "label-success",
                        "5" =>  "label-danger",
                    ],
                    "att"           =>  "status",
                    'foreignAtt'    => "STTS_NAME",
                    'url'           => "orders/details/",
                    'urlAtt'        =>  'id'
                ]
            ],
            'itemsCount',
            'created_at',
            'total'
        ];

        //Wishlist Array
        $this->data['wishlistList'] = $this->data['user']->wishlist;
        $this->data['wishlistCols'] = ['Barcode', 'Model Title', 'Arabic Title', "in Stock", 'Price', 'Offer'];
        $this->data['wishlistAtts'] = [
            'PROD_BRCD',
            ['attUrl' => ['url' => 'admin/products/details', 'urlAtt' => "id", "shownAtt" => "name"]],
            ['attUrl' => ['url' => 'admin/products/details', 'urlAtt' => "id", "shownAtt" => "arabic_name"]],
            ['sumForeign' => ['rel'=>"stock", "att"=>"INVT_CUNT"]] ,
            'PROD_PRCE',
            'PROD_OFFR',
        ];
        //Items Bought
        $this->data['boughtList'] = $this->data['user']->itemsBought();
        $this->data['boughtCols'] = ['Model', 'Count'];
        $this->data['boughtAtts'] = [
            'name',
            'itemCount'
        ];
    }

    public function home()
    {
        $this->initHomeArr(0);
        return view("users.table", $this->data);
    }

    public function latest()
    {
        $this->initHomeArr(1);
        return view("users.table", $this->data);
    }

    public function top()
    {
        $this->initHomeArr(2);
        return view("users.table", $this->data);
    }

    public function add()
    {
        $this->initAddArr();
        return view("users.add", $this->data);
    }

    public function edit($id)
    {
        $this->initAddArr($id);
        return view("users.add", $this->data);
    }

    public function profile($id)
    {
        $this->initProfileArr($id);
        return view("users.profile", $this->data);
    }

    public function insert(Request $request)
    {
        $request->validate([
            "name"              => "required",
            "pass"              => "nullable|between:4,24",
            "mob"               => "nullable|numeric",
            "mail"              => "nullable|email|unique:users,email",
            "gender"        => "required|exists:genders,id",
            "area"          => "required|exists:areas,id"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->password = $request->pass;
        $user->mobile = $request->mob;
        $user->email = $request->mail;
        $user->gender_id = $request->gender;
        $user->area_id = $request->area;
        $user->address = $request->address;

        $user->save();

        return redirect("admin/users/profile/" . $user->id);
    }

    public function update(Request $request)
    {
        $request->validate([
            "id"          => "required",
        ]);
        $user = User::findOrFail($request->id);
        $request->validate([
            "name"          => "required",
            "pass"          => "nullable|between:4,24",
            "mob"           => "nullable|numeric",
            "mail"          => "nullable",
            "gender"        => "required|exists:genders,id",
            "area"          => "required|exists:areas,id"
        ]);

        $user->name = $request->name;
        if (isset($request->pass))
            $user->password = $request->pass;
        $user->mobile = $request->mob;
        $user->email = $request->mail;
        $user->gender_id = $request->gender;
        $user->area_id = $request->area;
        $user->address = $request->address;

        $user->save();


        return redirect("admin/users/profile/" . $user->id);
    }
}
