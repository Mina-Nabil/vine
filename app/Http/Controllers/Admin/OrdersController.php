<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Driver;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentOption;
use App\Models\Product;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public $data;
    public $homeURL = "admin/orders/acrive";

    public function active()
    {
        $this->initTableArr(1);
        $this->data['newCount'] = Order::getOrdersCountByState(1);
        $this->data['readyCount'] = Order::getOrdersCountByState(2);
        $this->data['inDeliveryCount'] = Order::getOrdersCountByState(3);
        return view("orders.active", $this->data);
    }
    public function state(int $stateID)
    {
        $this->initTableArr(false, $stateID);
        if ($stateID > 0 && $stateID < 4) {
            $this->data['newCount'] = Order::getOrdersCountByState(1);
            $this->data['readyCount'] = Order::getOrdersCountByState(2);
            $this->data['inDeliveryCount'] = Order::getOrdersCountByState(3);
        } elseif ($stateID > 3 && $stateID < 7) {
            $this->data['deliveredCount'] = Order::getOrdersCountByState(4);
            $this->data['cancelledCount'] = Order::getOrdersCountByState(5);
            $this->data['returnedCount'] = Order::getOrdersCountByState(6);
            return view("orders.history", $this->data);
        } else {
            abort(404);
        }
        return view("orders.active", $this->data);
    }

    public function monthly(int $stateID = -1)
    {
        $this->initTableArr(false, $stateID, date('m'), date('Y'));
        $startDate  = $this->getStartDate(date('m'), date('Y'));
        $endDate    = $this->getEndDate(date('m'), date('Y'));
        $this->data['deliveredCount'] = Order::getOrdersCountByState(4, $startDate, $endDate);
        $this->data['cancelledCount'] = Order::getOrdersCountByState(5, $startDate, $endDate);
        $this->data['returnedCount'] = Order::getOrdersCountByState(6, $startDate, $endDate);
        $this->data['historyURL'] = "admin/orders/month";
        return view("orders.history", $this->data);
    }

    public function loadHistory()
    {
        $data['years'] = Order::selectRaw('YEAR(created_at) as order_year')->distinct()->get();
        return view("orders.prepareHistory", $data);
    }

    public function history($year, $month, $state = -1)
    {
        $this->initTableArr(false, $state, $month, $year);
        $startDate  = $this->getStartDate($month, $year);
        $endDate    = $this->getEndDate($month, $year);
        $this->data['historyURL'] = url('admin/orders/history/' . $year . '/' . $month);
        $this->data['deliveredCount'] = Order::getOrdersCountByState(4, $startDate, $endDate);
        $this->data['cancelledCount'] = Order::getOrdersCountByState(5, $startDate, $endDate);
        $this->data['returnedCount'] = Order::getOrdersCountByState(6, $startDate, $endDate);
        return view("orders.history", $this->data);
    }

    public function addNew()
    {
        $this->data['inventory']    =   Inventory::with("product")->where("amount", ">", 0)->get();
        $this->data['areas']        =   Area::active()->get();
        $this->data['users']        =   User::all();
        $this->data['formTitle'] = "Add New Order";
        $this->data['formURL'] = "admin/orders/insert";
        $this->data['isCancel'] = true;
        $this->data['homeURL']  = $this->homeURL;

        return view("orders.add", $this->data);
    }
    //////////////////////////////Order Details Page and Functions//////////////////////////////////////////
    public function details($id)
    {
        $data = Order::getOrderDetails($id); //returns order Array and Items Array

        //Status Panel
        $data['isOrderReady'] = true;
        foreach ($data['items'] as $item)
            if (!$item->is_verified) {
                $data['isOrderReady'] = false;
                break;
            }
        $data['isPartiallyReturned']    =   (($data['order']->status == Order::STATUSES[3] || $data['order']->status == Order::STATUSES[2]) && isset($data['order']->return_id) && is_numeric($data['order']->return_id));
        $data['isFullyReturned']        =   ($data['order']->status == Order::STATUSES[5]);
        $data['isCancelled']        =   ($data['order']->status == Order::STATUSES[4]);

        $data['setOrderNewUrl']             =   url('admin/orders/set/new/' . $data['order']->id);
        $data['setOrderReadyUrl']           =   url('admin/orders/set/ready/' . $data['order']->id);
        $data['setOrderInDeliveryUrl']      =   url('admin/orders/set/indelivery/' . $data['order']->id);
        $data['setOrderCancelledUrl']       =   url('admin/orders/set/cancelled/' . $data['order']->id);
        $data['setOrderDeliveredUrl']       =   url('admin/orders/set/delivered/' . $data['order']->id);
        $data['linkNewReturnUrl']           =   url('admin/orders/create/return/' . $data['order']->id);
        $data['returnUrl']                  =   url('admin/orders/return/' . $data['order']->id);

        //Add Items Panel
        $data['inventory']      =   Inventory::with("product")->where("amount", ">", 0)->get();
        $data['isCancel']       =   false;
        $data['addFormURL']     =   url('admin/orders/add/items/' . $id);

        //Driver Panel
        $data['drivers']      =   Driver::all();
        $data['assignDriverFormURL']     =   url('admin/orders/assign/driver');

        //Payment Panel
        $data['paymentURL']             =   url('admin/orders/collect/payment');
        $data['deliveryPaymentURL']     =   url('admin/orders/collect/delivery');
        $data['discountURL']            =   url('admin/orders/set/discount');

        //Edit Info Panel
        $data['areas']                  = Area::active()->get();
        $data['editInfoURL']             =   url('admin/orders/edit/details');

        $data['remainingMoney']         =   $data['order']->total - $data['order']->paid - $data['order']->discount;

        return view("orders.details", $data);
    }

    public function insertNewItems($orderID, Request $request)
    {
        $order = Order::findOrFail($orderID);
        DB::transaction(function () use ($order, $request) {
            $orderItemArray = $this->getOrderItemsArray($request);
            $invtArr = [];
            foreach ($orderItemArray as $item) {
                $orderItem = $order->order_items()->firstOrNew(
                    ['product_id' => $item['product_id']]
                );
                $orderItem->amount += $item['amount'];
                $orderItem->is_verified = 0;
                $orderItem->save();
                array_push($invtArr, [
                    'modelID'   =>  $item['product_id'],
                    'count'    =>  $item['amount']
                ]);
            }
            Inventory::insertEntry($invtArr, $order->id);
            $order->recalculateTotal();
            $order->addTimeline("New Items added to Order");
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function setReady($id)
    {

        $order = Order::findOrFail($id);
        DB::transaction(function () use ($order) {
            $isReady = true;
            foreach ($order->order_items as $item) {
                if ($item->is_verified == '0') {
                    $isReady = false;
                    break;
                }
            }
            if ($isReady) {
                $order->status = Order::STATUSES[1];
                $order->save();
                $order->addTimeline("Order set as Ready");
            }
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function setCancelled($id)
    {

        $order = Order::findOrFail($id);
        DB::transaction(function () use ($order) {
            $isReturned = true;
            foreach ($order->order_items as $item) {
                $inventory = Inventory::findOrfail($item->inventory_id);
                $inventory->amount += $item->amount;
                if (!$inventory->save()) {
                    $isReturned = false;
                    break;
                }
            }
            if ($isReturned) {
                $order->status = Order::STATUSES[4];
                $order->paid = 0;
                $order->delivery_date = date('Y-m-d H:i:s');
                $order->driver_id = null;
                $order->save();
                $order->addTimeline("Order cancelled :(");
            }
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function setNew($id)
    {

        $order = Order::findOrFail($id);
        $order->status = Order::STATUSES[0];
        $order->save();
        return redirect("admin/orders/details/" . $order->id);
    }

    public function setInDelivery($id)
    {
        $order = Order::findOrFail($id);
        DB::transaction(function () use ($order) {
            if ($order->status == Order::STATUSES[1] && isset($order->driver) && $order->driver->is_active) {
                $order->status = Order::STATUSES[2];
                $order->save();
            }
            $order->addTimeline("Order set as in delivery");
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function setDelivered($id)
    {
        $order = Order::findOrFail($id);
        DB::transaction(function () use ($order) {
            $remainingMoney = $order->total - $order->discount - $order->paid;
            if ($order->status == Order::STATUSES[2] && $remainingMoney == 0) {
                $order->status = 4;
                $order->delivery_date = date('Y-m-d H:i:s');
                $order->save();
            }
            $order->addTimeline("Order delivered :)");
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function setFullyReturned($id)
    {
        $order = Order::findOrFail($id);
        DB::transaction(function () use ($order) {
            $isReturned = true;
            foreach ($order->order_items as $item) {
                $inventory = Inventory::findOrfail($item->inventory_id);
                $inventory->amount += $item->amount;
                if (!$inventory->save()) {
                    $isReturned = false;
                    break;
                }
            }
            if ($isReturned) {
                $order->status = Order::STATUSES[5];
                $order->paid = 0;
                $order->delivery_date = date('Y-m-d H:i:s');
                $order->save();
                $order->addTimeline("Order fully returned :(");
            }
        });
    }

    public function setPartiallyReturned($id)
    {
        //This function will create new return order 
        $order = Order::findOrFail($id);
        $retOrder = new Order();
        DB::transaction(function () use ($order, $retOrder) {
            if (isset($order->user_id))
                $retOrder->user_id = $order->user_id;
            else {
                $retOrder->guest_name = $order->guest_name;
                $retOrder->guest_mobn = $order->guest_mobn;
            }
            $retOrder->created_at = date('Y-m-d H:i:s');
            $retOrder->delivery_date =  $retOrder->created_at;
            $retOrder->address = $order->address;
            $retOrder->note = "New Return Order for order number " . $order->id;
            $retOrder->area_id = $order->area_id;
            $retOrder->status = Order::STATUSES[5]; // new returned order
            $retOrder->total = 0;
            $retOrder->save();
            $order->return_id = $retOrder->id; // new returned order
            $order->save();
            $order->addTimeline("New Return Order opened");
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function assignDriver(Request $request)
    {
        $request->validate([
            'id' => "required",
            'driver' => "required|exists:drivers,id"
        ]);

        $order = Order::findOrFail($request->id);
        DB::transaction(function () use ($request, $order) {
            if ($order->status == Order::STATUSES[1] || $order->status == Order::STATUSES[0]) { // New or ready
                $order->driver_id = $request->driver;
                $order->save();
            }
            $driver = Driver::findOrFail($request->driver);
            $order->addTimeline($driver->name . " assigned as the order delivery man");
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function collectNormalPayment(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $request->validate([
            'id' => "required",
            'payment' => "required|min:0|max:" . $order->total
        ]);
        DB::transaction(function () use ($request, $order) {
            if (
                $order->status == Order::STATUSES[0] ||
                $order->status == Order::STATUSES[1] ||
                $order->status == Order::STATUSES[2]
            ) {
                $order->paid += $request->payment;
                $order->save();
            }
            $order->addTimeline($request->payment . "EGP collected as Normal Order payment");
        });

        return redirect("admin/orders/details/" . $order->id);
    }

    public function collectDeliveryPayment(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $request->validate([
            'id' => "required",
            'deliveryPaid' => "required|min:0"
        ]);
        DB::transaction(function () use ($request, $order) {
            $order->delivery_paid = $request->deliveryPaid;
            $order->save();
            $order->addTimeline($request->deliveryPaid . "EGP collected as Delivery payment");
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function setDiscount(Request $request)
    {
        $order = Order::findOrFail($request->id);
        $request->validate([
            'id' => "required",
            'discount' => "required|min:0|max:" . $order->total
        ]);
        DB::transaction(function () use ($request, $order) {
            if (
                $order->status == Order::STATUSES[0] ||
                $order->status == Order::STATUSES[1] ||
                $order->status == Order::STATUSES[2]
            ) {
                $order->discount = $request->discount;
                $order->save();
            }
            $order->addTimeline("Discount added on order, discount now is set to " . $order->discount);
        });

        return redirect("admin/orders/details/" . $order->id);
    }

    public function toggleItem($id)
    {

        $item = OrderItem::findOrfail($id);
        $order = Order::findOrfail($item->order_id);
        if ($order->status != Order::STATUSES[0]) { //still new
            return 'failed';
        }
        if ($item->is_verified) {
            $item->is_verified = 0;
        } else {
            $item->is_verified = 1;
        }
        $order->addTimeline("Item set as ready");
        return (($item->save()) ? 1 : 'failed');
    }

    public function deleteItem($id)
    {

        $item = OrderItem::findOrfail($id);
        $order = Order::findOrfail($item->order_id);
        DB::transaction(function () use ($order, $item) {
            if ($order->status != Order::STATUSES[0]) { //still new
                return 'failed';
            }
            Inventory::insertEntry([[
                'modelID'   =>  $item->product_id,
                'count'  =>  -1 * $item->amount
            ]], $order->id);

            $item->delete();

            $order->recalculateTotal();
            $order->addTimeline("Item deleted by dashboard user");
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    public function changeQuantity(Request $request)
    {
        $request->validate([
            "itemID" => "required",
            "count" => "required|numeric|min:0"
        ]);
        $orderItem = OrderItem::findOrFail($request->itemID);
        $order = Order::findOrfail($orderItem->order_id);
        DB::transaction(function () use ($order, $orderItem, $request) {
            if (($order->status == Order::STATUSES[3] || $order->status == Order::STATUSES[2]) && isset($order->return_id) && is_numeric($order->return_id)) {
                //if and in delivery or delivered and has a returned order

                //create new return item and add count to return item
                $returnOrder = Order::findOrFail($order->return_id);
                $returnedItem = $returnOrder->order_items()->firstOrNew([
                    'product_id' => $orderItem->product_id
                ]);
                $returnedItem->amount += $request->count;
                $returnedItem->is_verified = 1;
                $returnedItem->save();
                $returnOrder->recalculateTotal();

                //Adjust inventory
                Inventory::insertEntry([[
                    'modelID'   =>  $returnedItem->product_id,
                    'count'  =>  -1 * $returnedItem->amount
                ]], $order->id);

                //Adjust old order
                $orderItem->amount -= $request->count;
                if ($orderItem->amount < 1)
                    $orderItem->delete();
                else
                    $orderItem->save();
                $order->recalculateTotal();
                $order->addTimeline("Item added to Return Order");
            } elseif ($order->status != Order::STATUSES[0]) { //if it is not still new
                return redirect("admin/orders/details/" . $orderItem->order_id);
            } else {
                $oldAmount = $orderItem->amount;
                $orderItem->amount = $request->count;
                $orderItem->is_verified = 0;
                DB::transaction(function () use ($oldAmount, $orderItem, $order, $request) {
                    $orderItem->save();
                    $order->recalculateTotal();
                    $order->addTimeline("Item quantity changed by dashboard user");
                    Inventory::insertEntry([
                        ["modelID"  =>  $orderItem->product_id, 'count' => $request->count - $oldAmount]
                    ], $order->id);
                });
            }
        });
        return redirect("admin/orders/details/" . $orderItem->order_id);
    }

    public function editOrderInfo(Request $request)
    {
        $request->validate([
            "id" => "required",

        ]);
        $order = Order::findOrfail($request->id);
        DB::transaction(function () use ($request, $order) {
            $order->address = $request->address;
            $order->note = $request->note;
            $order->area_id = $request->area;
            $order->save();
            $order->addTimeline("Order edited by dashboard user");
        });
        return redirect("admin/orders/details/" . $order->id);
    }

    ////////////////////////////Insert Order from dashboard///////////////////////////

    public function insert(Request $request)
    {

        $request->validate([
            "user"          =>  "required_if:guest,2|nullable|exists:users,id",
            "guestName"     =>  "required_if:guest,1",
            "guestMob"     =>  "required_if:guest,1",
            "area"          =>  "required",
            "address"      =>  "required",
        ]);

        $order = Order::addNew($request->user, $request->mobN, $request->address, $request->area, $request->note, $this->getOrderItemsObjectArray($request), $this->getOrderTotal($request), $request->guestName);
        $order->addTimeline("Order Opened by dashboard user " .  $request->user()->name ?? '');


        return redirect("admin/orders/details/" . $order->id);
    }


    /***
     * 
     * @param $isActive int
     * if active = 1 , history = 2
     * @param $state
     * 1 New - 2 Ready - 3 In Delivery - 4 Delivered - 5 Cancelled - 6 Returned
     * @param $year int
     * if history set year e.g 2020
     * 
     */
    private function initTableArr($isActive, $state = -1, $month = -1, $year = -1)
    {
        if ($isActive == 1)
            $this->data['items']    = Order::getActiveOrders();
        elseif ($month == -1 && $year == -1) {
            $this->data['items']    = Order::getActiveOrders($state);
        } else {
            $this->data['items']    = Order::getOrdersByDate(false, $month, $year, $state);
        }
        $this->data['cardTitle'] = true;
        $this->data['cols'] = ['id', 'Client', 'Status', 'Area', 'Items', 'Ordered On', 'Closed On', 'Total'];
        $this->data['atts'] = [
            ['attUrl' => ['url' => "admin/orders/details", "shownAtt" => 'id', "urlAtt" => 'id']],
            ['urlOrStatic' => ['url' => "admin/users/profile", "shownAtt" => 'client_name', "urlAtt" => 'user_id', 'static' => 'guest_name']],
            [
                'stateQuery' => [
                    "classes" => [
                        Order::STATUSES[0] => "label-info",
                        Order::STATUSES[1] => "label-warning",
                        Order::STATUSES[2] =>  "label-dark bg-dark",
                        Order::STATUSES[3] =>  "label-success",
                        Order::STATUSES[4] =>  "label-danger",
                        Order::STATUSES[5] =>  "label-primary",
                    ],
                    "att"           =>  "status",
                    'url'           => "admin/orders/details/",
                    'urlAtt'        =>  'id'
                ]
            ],
            'area_name',
            'itemsCount',
            'open_date',
            'delivery_date',
            'total'
        ];
    }

    private function getOrderItemsArray(Request $request)
    {
        $retArr = array();
        foreach ($request->item as $index => $item) {
            array_push(
                $retArr,
                ["product_id" => $item, "amount" => $request->count[$index]]
            );
        }
        return $retArr;
    }

    private function getOrderItemsObjectArray(Request $request)
    {
        $retArr = array();
        foreach ($request->item as $index => $item) {
            array_push($retArr, new OrderItem(
                ["product_id" => $item, "amount" => $request->count[$index]]
            ));
        }
        return $retArr;
    }

    private function getOrderTotal(Request $request)
    {
        $total = 0;
        foreach ($request->item as $index => $item) {
            $product = Inventory::with("product")->findOrFail($item)->product;
            $price = $product->price - $product->offer;
            $total += $request->count[$index] * $price;
        }
        return $total;
    }

    ///////////////Helper Functions
    private function getStartDate($month, $year)
    {
        $retDate = null;
        if ($month == -1) {
            $retDate = $year . '-01-01 00:00:00';
        } else {
            $retDate = $year . '-' . $month . '-01 00:00:00';
        }
        return $retDate;
    }

    private function getEndDate($month, $year)
    {
        $retDate = null;
        if ($month == -1) {
            $retDate = $year . '-12-31 23:59:59';
        } else {
            $retDate = (new DateTime($year . '-' . $month . '-01'))->format('Y-m-t 23:59:59');
        }
        return $retDate;
    }
}
