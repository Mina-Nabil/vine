<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPass;
use App\Models\Area;
use App\Models\Color;
use App\Models\Gender;
use App\Models\SiteInfo;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\User;
use App\Services\WSBaseDataManager;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BuyerController extends Controller
{
    private $data;

    ///USER functions
    public function loadLoginPage()
    {
        $data = WSBaseDataManager::getSiteData();
        if ($data['is_logged'] == true) {
            return redirect('home');
        }
        return view('frontend.auth.login', $data);
    }

    public function login(Request $request)
    {
        Validator::make($request->all(), [
            "email"     =>  "required",
            "password"  =>  "required"
        ], [
            "email.exists" => "The entered email address doesn't exist!"
        ])->validate();

        if (Auth::guard("web")->attempt([
            "email" => $request->email,
            "password"  =>  $request->password
        ])) {
            return back();
        } else {
            return redirect("admin/login")->withErrors(["password" => "invalid credentials please try again"]);
        }
    }

    public function googleLogin(Request $request)
    {

        Validator::make($request->all(), [
            "credential"     =>  "required",
        ])->validate();

        Log::info($request->credential);
        $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($request->credential);
        Log::info($payload);
        User::googleLogin($payload);

        if (User::googleLogin($payload)) {
            return redirect()->action([SiteController::class, 'home']);
        } else {
            return redirect()->action([self::class, 'loadLoginPage'])->withErrors(["google_login" => "Google Login failed"]);
        }
    }

    public function logout()
    {
        Auth::guard("web")->logout();
        return back();
    }

    public function loadRegister()
    {
        $data = WSBaseDataManager::getSiteData();
        // if($data['is_logged'] == true){
        //     return redirect('home');
        // }
        $data['areas'] = Area::all();
        $data['genders'] = Gender::all();
        return view('frontend.auth.register', $data);
    }

    public function register(Request $request)
    {
        Validator::make($request->all(), [
            "name"      =>  "required",
            "email"     =>  "required|unique:users,email",
            "area"      =>  "required|exists:areas,id",
            "gender"    =>  "required|exists:genders,id",
            "mobile"  =>  "required|min:11",
            "password"  =>  "required|min:6",
        ], [
            "email.unique" => "The entered email address already exists :/"
        ])->validate();

        $newUser = User::create($request->name, $request->email, $request->area, $request->gender, $request->mobile, $request->address, $request->password);

        if ($newUser != null) {
            Auth::guard("web")->attempt([
                "email" => $newUser->email,
                "password"  => $request->password,
            ], true);
            return redirect()->route("home");
        } else {
            return redirect()->route("register");
        }
    }

    public function loadForgetPassPage()
    {
        $data = WSBaseDataManager::getSiteData();
        return view('frontend.auth.forgetpass', $data);
    }

    public function sendForgetPassMail(Request $request)
    {
        $data = WSBaseDataManager::getSiteData();
        $user = User::getUserByMail($request->email);
        if ($user != null) {
            $encryptedID = Crypt::encryptString($user->id);
            try {
                Mail::to($request->email)->send(new ForgetPass(url("changepass/" . $encryptedID)));
            } catch (\Exception $e) {
                throw $e;
            }
        }

        return view('frontend.auth.mailsent', $data);
    }

    public function changePassForm($encryptedID)
    {
        $data = WSBaseDataManager::getSiteData();
        $data['encryptedID'] = $encryptedID;
        $data['formURL'] = url('changePass');

        return view('frontend.auth.restorepass', $data);
    }

    public function changePass(Request $request)
    {
        $request->validate([
            "password"  =>  "required|min:6",
        ]);
        if (isset($request->encryptedID)) {
            $id = Crypt::decryptString($request->encryptedID);
            $user = User::findOrFail($id);
            $user->updatePassword($request->password);
            return redirect()->route("login");
        } else {
            abort(403);
        }
    }

    public function previousltyBoughtItems(Request $request)
    {
        $applyNewFilters = $request->isMethod('POST');
        //loading applied filters
        if ($applyNewFilters) {
            $colorFilters = $request->color_filters ?? null;
            $sizeFilters = $request->size_filters ?? null;
            $priceFilters = $request->price_filters ?? null;
            $sortOption = $request->sort_option ?? null;
        } else {
            $colorFilters =  $request->input('applied_color_filters') ?? null;
            $sizeFilters =  $request->input('applied_size_filters') ?? null;
            $priceFilters =  $request->input('applied_price_filters') ?? null;
            $sortOption =  $request->input('applied_sort_option') ?? null;
        }
        $loggedInUser = User::with('wishlist')->findOrFail(Auth::id());
        $productsQuery = $loggedInUser->previouslyBoughtQuery();
        $allBoughtProducts = $productsQuery->get();
        $data = WSBaseDataManager::getCollectionPageData(
            $applyNewFilters,
            WSBaseDataManager::COLLECTION_PAGES[1],
            $productsQuery,
            $priceFilters,
            $sortOption,
            null,
            $request->per_page ?? ($request->input('per_page') ?? 28)
        );

        return view("frontend.catalog.collection", $data);
    }

    public function addToWishlist(Request $request)
    {
        if ($request->user() == null ||  !is_a($request->user(), User::class)) {
            return response(json_encode((object)[
                "added" =>  false,
                "msg"   =>  "Adding to Wishlist failed. Are you logged in?"
            ]));
        }
        $request->validate([
            "id"    => "required|exists:products"
        ]);
        if ($request->user()->addToWishlist($request->id)) {
            return response(json_encode((object)["added" => true, "msg" => "Model Successfully added to wishlist! "]));
        } else {
            return response(json_encode((object)["added" => false, "msg" => "Server issue.. Please try again later "]));
        }
    }
}
