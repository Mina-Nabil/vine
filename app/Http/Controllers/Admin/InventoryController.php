<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    public function entry()
    {
        //models data
        $data['products'] = Product::with('subcategory', 'subcategory.category')->get();

        //form data
        $data['formURL'] = 'admin/inventory/insert/entry';
        $data['formTitle'] = "New Stock Entry";

        return view("inventory.entry", $data);
    }

    public function insert(Request $request)
    {
        $entryArr = $this->getEntryArray($request);
        
        Inventory::insertEntry($entryArr );

        return redirect("admin/inventory/current/stock");
    }

    public function stock()
    {

        $data['items'] = Inventory::with(["product"])->get();

        $data['title'] = "Stock List";
        $data['subTitle'] = "View Current Stock";
        $data['cols'] = ['Model',  'Count'];
        $data['atts'] = [ 
            ['foreignUrl' => ['admin/roducts/details', 'product_id', 'product', 'name']],
            'amount'
        ];
        $data['deleteAllStock'] = url('admin/inventory/refresh');

        return view("inventory.stock", $data);
    }

    public function transactionDetails($code)
    {
        $data['items'] = Inventory::getTransactionByCode($code);
        abort_if(!isset($data['items'][0]), 404);
        $data['title'] = "Entry " .( (isset($data['items'][0]->INTR_CODE)) ? $data['items'][0]->INTR_CODE : "") .  " details";
        $data['subTitle'] = "Inventory Entry Details" . ((isset($data['items'][0]->name)) ? " done by '" . $data['items'][0]->name . "'": "") . 
        ((isset($data['items'][0]->created_at)) ? " on " . $data['items'][0]->created_at : "");
        $data['cols'] = ['Code', 'Product', 'In', 'Out'];
        $data['atts'] = [ 
            "code",
            ['attUrl' => ["url" => "products/profile", 'urlAtt'=>'product_id', 'shownAtt'=>'name']], 

            'in',
            'out',
        ];
        $data['deleteAllStock'] = url('admin/inventory/refresh');

        return view("inventory.stock", $data);
    }

    public function transactions()
    {
        $data['items'] = Inventory::getGroupedTransactions();
        $data['title'] = "Latest Inventory Entries";
        $data['subTitle'] = "View the latest 500 inventory entries - Each Entry can be shown by the entry code";
        $data['cols'] = ['Code', 'Date', 'Done by', 'Total In', 'Total Out'];
        $data['atts'] = [ 
            ['attUrl' => ['url' =>'admin/inventory/transaction', 'shownAtt' => 'code', 'urlAtt' => 'code']],
            "trans_date", 
            'username', 
            'totalIn',
            'totalOut',
        ];
        $data['deleteAllStock'] = url('admin/inventory/refresh');
        return view("inventory.stock", $data);
    }

    public function refresh(){
        Inventory::refreshAllStock();
        return redirect()->action([InventoryController::class, 'stock']);
    }


    private function getEntryArray($request)
    {
        $ret = array();

        for ($i = 0; isset($request->count[$i]); $i++) {
            $ret[$i] = [
                "modelID" => $request->model[$i],
                "count" => $request->count[$i],
            ];
        }
        return $ret;
    }
}
