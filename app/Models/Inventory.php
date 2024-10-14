<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Inventory extends Model
{
    protected $table = "inventory";
    protected $fillable = ['product_id', 'amount'];
    protected $hidden = ['product_id'];
    protected $appends = ["available_units"];

    //accessors
    public function getAvailableUnitsAttribute()
    {
        return $this->amount;
    }

    //functions
    public static function checkProductAvailability($prod_id): int
    {
        return self::where([
            ["product_id",  $prod_id],
        ])->select("amount")->first()->amount ?? 0;
    }

    public static function getInventoryID($prod_id): int
    {
        return self::where([
            ["product_id",  $prod_id]
        ])->firstOrFail()->id;
    }


    //relations
    public function product()
    {
        return $this->belongsTo(Product::class);
    }



    //CRUD
    static public function insertEntry($entryArr, $orderID = null)
    {
        $transactionCode = date_format(now(), "ymdHis");
        $date = date_format(now(), "Y-m-d H:i:s");
        DB::transaction(function () use ($entryArr, $transactionCode, $orderID, $date) {
            foreach ($entryArr as $row) {
                self::insert(
                    $row['modelID'],
                    (($orderID == null)) ?
                        $row['count'] :
                        -1 * $row['count'],
                    $transactionCode,
                    $orderID,
                    $date
                );
            }
        });
    }
    static public function insertSingleEntry($model_id, $count, $transactionCode, $date)
    {

        self::insert($model_id, $count, $transactionCode, null, $date);
    }

    static public function insert($modelID, $count, $transactionCode, $orderID = null, $date = null)
    {

        DB::transaction(function () use ($modelID, $count, $transactionCode, $orderID, $date) {
            $inventoryRow = self::firstOrNew(["product_id" => $modelID,]);
            $inventoryRow->amount += $count;
            // dd($inventoryRow);
            $inventoryRow->save();
            // if (isset($inventoryRow->amount)) {
            //     $inventoryRow->amount += $count;
            //     $inventoryRow->save();
            // } else {
            //     $inventoryRow = new Inventory();
            //     $inventoryRow->product_id = $modelID;
            //     $inventoryRow->amount = $count;
            //     $inventoryRow->save();
            // }
            if ($count > 0)
                self::addNewTransaction($inventoryRow->id, $inventoryRow->amount, $transactionCode, $orderID, $count, 0, $date);
            else
                self::addNewTransaction($inventoryRow->id, $inventoryRow->amount, $transactionCode, $orderID, 0, $count, $date);
        });
    }

    static public function refreshAllStock()
    {
        $transactionCode = date_format(now(), "ymdHis");
        $date = date_format(now(), "Y-m-d H:i:s");
        DB::transaction(function () use ($transactionCode, $date) {
            $entries = self::where('amount', '>', 0)->get();
            foreach ($entries as $entry) {
                self::insertSingleEntry($entry->product_id, -1 * $entry->amount, $transactionCode, $date);
            }
        });
    }

    static public function getGroupedTransactions()
    {
        return DB::table("inventory_transactions")->join("dash_users", "inventory_transactions.dash_user_id", "=", "dash_users.id")
            ->selectRaw("code, inventory_transactions.created_at as trans_date, inventory_transactions.dash_user_id, SUM(`in`) as totalIn, SUM(`out`) as totalOut, dash_users.name as username")
            ->groupByRaw("code, trans_date, dash_user_id, username")
            ->orderByDesc("trans_date")
            ->limit(500)
            ->get();
    }

    static public function getTransactionByCode($code)
    {
        return DB::table("inventory_transactions")->join("dash_users", "dash_user_id", "=", "dash_users.id")
            ->join("inventory", "inventory_transactions.inventory_id", "=", "inventory.id")
            ->join("products", "inventory.product_id", "=", "products.id")
            ->select("inventory_transactions.*", "dash_users.name as username", "products.name", "inventory.product_id")
            ->where("code", $code)
            ->get();
    }

    static private function addNewTransaction($inventoryID, $balance, $transactionCode, $orderID = null, $in = 0, $out = 0, $date = null)
    {
        DB::table("inventory_transactions")->insert([
            "created_at"     => ($date) ?? date_format(now(), "Y-m-d H:i:s"),
            "code"     =>  $transactionCode,
            "inventory_id"  =>  $inventoryID,
            "dash_user_id"  =>  Auth::id() ?? 1,
            'in'       =>  $in,
            'out'      =>  $out,
            'balance'     =>  $balance,
            'order_id' =>  $orderID
        ]);
    }
}
