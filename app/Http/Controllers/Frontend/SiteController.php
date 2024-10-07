<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\User;
use App\Mail\ContactUsMail;
use App\Services\WSBaseDataManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SiteController extends Controller
{

    public function home()
    {
        $data = WSBaseDataManager::getHomePageData();
        $flag = session('flag');
        switch ($flag) {
            case 'showOrderSubmitted':
                $data['showOrderSubmitted'] = true;
                break;
            case 'showOrderFailed':
                $data['showOrderFailed'] = true;
                break;
            case 'emailSent':
                $data['emailSent'] = true;
                break;
            default:
                break;
        }
        return view('frontend.home', $data);
    }

    public function all($id = 0)
    {
        $data = WSBaseDataManager::getSiteData();
        if ($id != 0)
            $data['subcategories'] = SubCategory::ofCategory($id)->get();
        return view('frontend.catalog.categories', $data);
    }

    public function productPage($id)
    {
        $data = WSBaseDataManager::getSiteData();
        $data['product'] = Product::with("images", "stock", "tags", "subcategory", "sizechart")->findOrFail($id)->append("available_sizes", "available_colors");
        return view('frontend.catalog.product', $data);
    }

    public function productInfo(Request $request)
    {
        $request->validate([
            "id"    => "required|exists:products"
        ]);
        $product = Product::with("images", "stock", "tags")->find($request->id);
        return response($product->append("available_sizes", "available_colors")->toJson())->withHeaders([
            'Content-Type: application/json'
        ]);
    }

    public function subcategory($id, Request $request)
    {
        $subcategory = SubCategory::with('category')->findOrFail($id);

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

        $data = WSBaseDataManager::getCollectionPageData(
            WSBaseDataManager::COLLECTION_PAGES[2] /*subcategory page*/,
            $applyNewFilters,
            Product::ofSubcategory($id) /*base products query*/,
            $subcategory->available_colors,
            $colorFilters,
            $subcategory->available_sizes,
            $sizeFilters,
            $priceFilters,
            $sortOption,
            $subcategory,
            $request->per_page ?? ($request->input('per_page') ?? 28) /*perPageValue*/,
        );

        return view("frontend.catalog.collection", $data);
    }

    public function wishlist(Request $request)
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
        $productsQuery = $loggedInUser->wishlistQuery();
        $data = WSBaseDataManager::getCollectionPageData(
            WSBaseDataManager::COLLECTION_PAGES[0],
            $applyNewFilters,
            $productsQuery,
            Color::getAvailableColors($loggedInUser->wishlist),
            $colorFilters,
            Size::getAvailableSizes($loggedInUser->wishlist),
            $sizeFilters,
            $priceFilters,
            $sortOption,
            null,
            $request->per_page ?? ($request->input('per_page') ?? 28)
        );

        return view("frontend.catalog.collection", $data);
    }

    public function search(Request $request)
    {
        $request->validate([
            "q"   =>  "required"
        ]);

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
        $productsQuery = Product::searchQuery($request->q);
        $availableProducts = $productsQuery->get();
        $data = WSBaseDataManager::getCollectionPageData(
            WSBaseDataManager::COLLECTION_PAGES[0],
            $applyNewFilters,
            $productsQuery,
            Color::getAvailableColors($availableProducts),
            $colorFilters,
            Size::getAvailableSizes($availableProducts),
            $sizeFilters,
            $priceFilters,
            $sortOption,
            null,
            $request->per_page ?? ($request->input('per_page') ?? 28)
        );

        return view("frontend.catalog.collection", $data);
    }

    public function aboutus()
    {
        $data = WSBaseDataManager::getSiteData();
        return view('frontend.aboutus', $data);
    }

    public function contactus()
    {
        $data = WSBaseDataManager::getSiteData();
        return view('frontend.contactus', $data);
    }

    public function sendContactUsEmail(Request $request)
    {
        $request->validate([
            "name"  =>  "required",
            "email"  =>  "required",
            "phone"  =>  "required",
            "message"  =>  "required",
        ]);
        try {
            Mail::to(env('MAIL_TO_ADDRESS'))->send(new ContactUsMail($request->name, $request->email, $request->phone, $request->message));
            return redirect('home')->with("flag", "emailSent");
        } catch (\Exception $e) {
            report($e);
        }
        return redirect('home');
    }

    public function searchForm()
    {
        $data = WSBaseDataManager::getSiteData();
        return view('frontend.catalog.search', $data);
    }

    public function notfound_404()
    {
        $data = WSBaseDataManager::getSiteData();
        return view('frontend.errors.404', $data);
    }
}
