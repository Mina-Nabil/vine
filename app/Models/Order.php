<?php

namespace App\Models;

use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = "orders";
    public $timestamps = true;
    const STATUSES = [
        'New',
        'Ready',
        'In Delivery',
        'Delivered',
        'Cancelled',
        'Returned'
    ];


    //order functions
    public function recalculateTotal()
    {
        $total = 0;
        foreach ($this->order_items as $item) {
            $product = Inventory::with("product")->findOrFail($item->product_id)->product;
            $price = $product->price - $product->offer;
            $total += $item->amount * $price;
        }
        $this->total = $total;
        $this->save();
    }

    //static queries
    public static function addNew($user, $mobN, $address, $area, $option, $note, $ItemsArray, $total, $guestName): Order
    {
        $order = new Order();
        DB::transaction(function () use ($order, $user, $guestName, $mobN, $address, $option, $note, $area, $ItemsArray, $total) {
            if (isset($user))
                $order->user_id = $user;
            else {
                $order->guest_name = $guestName;
            }
            $order->guest_mobn = $mobN;
            $order->created_at = date('Y-m-d H:i:s');
            $order->address = $address;
            $order->note = $note;
            $order->area_id = $area;
            // $order->ORDR_PYOP_ID = $option;
            $order->status = 'new'; // new order
            $order->dash_user_id = Auth::user() && is_a(Auth::user(), DashUser::class) ? Auth::id() : null; // new order

            $orderItemArray = $ItemsArray;
            $order->total = $total;

            $order->save();
            $order->order_items()->saveMany($orderItemArray);
            foreach ($orderItemArray as $item) {
                $inventory = Inventory::findOrFail($item->product_id);
                $inventory->amount -= $item->amount;
                $inventory->save();
            }
        });
        return $order;
    }

    public static function getOrdersByDate(bool $currentMonth = true, int $month = -1, int $year = -1, int $state = -1)
    {

        $startDate = '';
        $endDate = '';

        if ($currentMonth) {
            $startDate = (new DateTime("first day of this month"))->format('Y-m-d 0:0:0');
            $endDate = (date_add((new DateTime('now')), new DateInterval("P01M")))->format('Y-m-1 0:0:0');
        } elseif ($month != -1 && $year == -1) {
            assert((0 < $month) && ($month < 13), 'Invalid Month');
            $year = date('Y');
            $startDate = $year . '-' . $month . '-01';
            $endDate   = date_add((new DateTime($startDate)), new DateInterval("P01M"))->format('Y-m-1 0:0:0');
        } elseif ($month == -1 && $year != -1) {
            $startDate = $year . '-01-01 00:00:00';
            $endDate = $year . '-12-31 12:59:59';
        } else {
            assert((0 < $month) && ($month < 13), 'Invalid Month');
            $startDate = $year . '-' . $month . '-01';
            $endDate   = date_add((new DateTime($startDate)), new DateInterval("P01M"))->format('Y-m-1 0:0:0');
        }


        $query =  self::tableQuery();

        if ($state > 0 && $state < 7) {
            $query = $query->where("status", "=", $state);
        } else {
            $query = $query->where("status", ">", 3);
        }
        $query->whereBetween("delivery_date", [$startDate, $endDate]);

        return $query->get();
    }

    public static function getOrdersByUser($userID)
    {
        $query = self::tableQuery();
        $query = $query->where('orders.user_id', $userID);
        return $query->get();
    }

    public static function getActiveOrders($state = -1)
    {
        $query = self::tableQuery();
        if ($state > 0 && $state < 6) {
            $query = $query->where("status", "=", $state);
        } else {
            $query = $query->where("status", "=", 1)->orWhere("status", "=", 1)
                ->orWhere("status", "=", 2)
                ->orWhere("status", "=", 3);
        }
        return $query->get();
    }

    public static function getOrderDetails($id)
    {
        $ret['order'] = DB::table("orders")
            ->join("areas", "orders.area_id", "=", "areas.id")
            ->Leftjoin("users", "orders.user_id", "=", "users.id")
            ->Leftjoin("dash_users", "orders.dash_user_id", "=", "dash_users.id")
            ->Leftjoin("drivers", "driver_id", "=", "drivers.id")
            ->Leftjoin("order_items", "order_items.order_id", "=", "orders.id")
            // ->join("payment_options", "ORDR_PYOP_ID", "=", "payment_options.id")
            ->select("orders.*", 'drivers.name', "orders.guest_name", "order_status.STTS_NAME", "areas.name as area_name", "rate", "users.name", "users.mobile", "dash_users.name")->selectRaw("SUM(amount) as itemsCount")
            ->groupBy("orders.id", "order_status.status", "areas.name", "users.name", "users.mobile")
            ->where('orders.id', $id)->get()->first();

        $ret['items'] = DB::table('order_items')
            ->join("products", "inventory.product_id", "=", "products.id")
            ->select("order_items.id", "products.name as product_name", "amount", "is_verified", "price", "offer")
            ->where("order_items.order_id", "=", $id)
            ->get();

        $ret['timeline'] = DB::table('timeline')
            ->join('dash_users', 'TMLN_DASH_ID', '=', 'dash_users.id')
            ->select('DASH_USNM', 'timeline.*')
            ->orderByDesc('timeline.id')
            ->where('TMLN_ORDR_ID', $id)->get();

        return $ret;
    }

    public static function getOrdersCountByState($state, $startDate = null, $endDate = null)
    {
        $query = DB::table("orders")->where("orders.status", $state);

        if (!is_null($startDate) && !is_null($endDate)) {
            $query->whereBetween('delivery_date', [$startDate, $endDate]);
        }

        return $query->get()->count();
    }

    private static function tableQuery()
    {
        return DB::table("orders")
            ->join("order_status", "ORDR_STTS_ID", "=", "order_status.id")
            ->join("areas", "ORDR_AREA_ID", "=", "areas.id")
            ->Leftjoin("users", "ORDR_USER_ID", "=", "users.id")
            ->Leftjoin("dash_users", "ORDR_DASH_ID", "=", "dash_users.id")
            ->Leftjoin("order_items", "ORIT_ORDR_ID", "=", "orders.id")
            // ->join("payment_options", "ORDR_PYOP_ID", "=", "payment_options.id")
            ->select("orders.*", "order_status.STTS_NAME", "dash_users.DASH_USNM", "areas.AREA_NAME", "users.USER_NAME", "users.USER_MOBN")->selectRaw("SUM(ORIT_CUNT) as itemsCount")
            ->groupBy("orders.id", "orders.ORDR_STTS_ID", "orders.ORDR_USER_ID", "orders.ORDR_OPEN_DATE", "order_status.STTS_NAME", "areas.AREA_NAME", "users.USER_NAME", "users.USER_MOBN", "payment_options.PYOP_NAME");
    }

    //relations
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function timeline()
    {
        return $this->hasMany("timeline", "TMLN_ORDR_ID", "id");
    }

    public function client()
    {
        return $this->belongsTo("App\Models\User", "ORDR_USER_ID", "id");
    }

    public function area()
    {
        return $this->belongsTo("App\Models\Area", "ORDR_AREA_ID", "id");
    }

    public function driver()
    {
        return $this->belongsTo("App\Models\Driver", "driver_id", "id");
    }

    // public function paymentOption()
    // {
    //     return $this->belongsTo("payment_options", "ORDR_AREA_ID", "id");
    // }


    public function addTimeline($text)
    {
        $timeline = new Timeline();
        $timeline->TMLN_DASH_ID = (Auth::user() && is_a(Auth::user(), DashUser::class)) ? Auth::user()->id : NULL;
        $timeline->TMLN_ORDR_ID = $this->id;
        $timeline->TMLN_TEXT    = $text;
        $timeline->save();
    }
}
