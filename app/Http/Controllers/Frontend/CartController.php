<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\WSBaseDataManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;

class CartController extends Controller
{
    public function submitOrder(Request $request)
    {
        $request->validate([
            "user"          =>  "required_if:guest,2|nullable|exists:users,id",
            "guestName"     =>  "required_if:guest,1",
            "area"          =>  "required",
            "option"        =>  "required",
            "address"      =>  "required",
            "phone"      =>  "required",
        ]);

        $loadedCart = User::getUserCart();
        $itemsArray = $this->getOrderItemsObjectArray($loadedCart->items);

        $order = Order::addNew($request->user, $request->phone, $request->address, $request->area, $request->option, $request->note, $itemsArray, $loadedCart->total, $request->guestName);
        if ($order) {
            $order->addTimeline("Order Opened by client");
            $request->session()->forget('cart');
            $msgClientName = '';
            if (isset($request->user)) {
                $msgClientName = (User::findOrFail($request->user))->USER_NAME;
            } else {
                $msgClientName = $request->guestName;
            }
        //    SendOrderConfirmationSMS::dispatch($msgClientName, $request->phone, str_pad($order->id, 5, '0', STR_PAD_LEFT));
            return  redirect('home')->with("flag", "showOrderSubmitted"); 
        } else {
            return redirect('home')->with("flag", "showOrderFailed");
        }
    }

    public function cart()
    {
        $data = WSBaseDataManager::getSiteData(true);
        return view('frontend.cart.cart', $data);
    }

    public function checkout()
    {
        $data = WSBaseDataManager::getSiteData();
        $data['areas']  = Area::all();
        return view('frontend.cart.checkout', $data);
    }

    public function submitCart(Request $request)
    {

        $request->validate([
            "product"   =>  "required|array",
            "color"     =>  "required|array",
            "size"      =>  "required|array",
            "quantity"  =>  "required|array",

        ]);
        $this->updateCartFromCartArray($request);
        if (isset($request->update)) {
            return redirect('cart');
        } elseif (isset($request->checkout)) {
            return redirect('checkout');
        } else {
            return redirect('home');
        }
    }

    public function add(Request $request)
    {
        $request->validate([
            "id"            =>  "required|exists:products",
            "color_id"      =>  "required|exists:colors,id",
            "size_id"       =>  "required|exists:sizes,id",
            "quantity"      =>  "required|numeric"
        ]);

        $new_cart_item = [
            "details"   =>  Product::findOrFail($request->id),
        ];

        $new_cart_item["variant"] = $new_cart_item["size"]->code . " / " . $new_cart_item["color"]->name;


        if ($request->session()->has("cart")) {
            //cart found
            $cartArray = $request->session()->get("cart");
            //the cart array key's format is "[prod_id]-[color_id]-[size_id]"
            $alreadyInCart = ($cartArray[$request->id . "-" . $request->color_id . "-" . $request->size_id] ?? 0);

            $itemsAvailable = Inventory::checkProductAvailability($request->id, $request->color_id, $request->size_id);
            if ($itemsAvailable < $request->quantity + $alreadyInCart) {
                return json_encode((object) ["added" => false, "msg" => "Product addition to cart failed! Can't add more of this product to the cart."]);
            }

            $cartArray[$request->id . "-" . $request->color_id . "-" . $request->size_id] =
                $alreadyInCart + $request->quantity;
            $new_cart_item["quantity"] = $cartArray[$request->id . "-" . $request->color_id . "-" . $request->size_id];
        } else {
            $itemsAvailable = Inventory::checkProductAvailability($request->id, $request->color_id, $request->size_id);
            if ($itemsAvailable < $request->quantity) {
                return json_encode((object) ["added" => false, "msg" => "Product addition to cart failed! Item Unavailable"]);
            }
            //new cart created by adding first item
            $cartArray = [
                $request->id . "-" . $request->color_id . "-" . $request->size_id =>  $request->quantity
            ];
            $new_cart_item["quantity"] = $request->quantity;
        }
        $request->session()->put("cart", $cartArray);
        return json_encode(
            [
                "added" => true,
                "cart" => User::getUserCart($request),
                "product"   =>  $new_cart_item
            ],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function remove(Request $request)
    {
        $request->validate([
            "id"        =>  "required|exists:products",
            "color_id"  =>  "required|exists:colors,id",
            "size_id"  =>  "required|exists:sizes,id",
        ]);
        $cartArray = session("cart");

        if (isset($cartArray[$request->id . "-" . $request->color_id . "-" . $request->size_id])) {
            unset($cartArray[$request->id . "-" . $request->color_id . "-" . $request->size_id]);
        }

        $request->session()->put("cart", $cartArray);

        return json_encode([
            "cart" => User::getUserCart($request)
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param array $cart the cart array retrieved from the cart page
     */
    private function updateCartFromCartArray(Request $cartRequest): array
    {
        Session::remove('cart');

        $newCartArr = array();
        foreach ($cartRequest->product as $index => $prodID) {
            $newCartArr[$prodID . '-' . $cartRequest->color[$index] . '-' . $cartRequest->size[$index]] = $cartRequest->quantity[$index];
        }
        Session::put('cart', $newCartArr);
        return $newCartArr;
    }


    private function getOrderItemsObjectArray(array $itemsArray)
    {
        $retArr = array();
        foreach ($itemsArray as $item) {
            $inventoryID = Inventory::getInventoryID($item->id, $item->color->id, $item->size->id);
            array_push($retArr, new OrderItem(
                ["ORIT_INVT_ID" => $inventoryID, "ORIT_CUNT" => $item->quantity]
            ));
        }
        return $retArr;
    }
}
