<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use App\Models\Slide;
use Illuminate\Http\Request;

class WebsiteInfoController extends Controller
{
    private $homeURL = "admin/website/info";

    ///Slides functions
    public function slides()
    {
        $data['slides'] = Slide::get();
        $data['deleteURL'] = url("admin/website/slides/delete");
        return view("settings.slides", $data);
    }

    public function addSlide(Request $request)
    {
        $request->validate([
            "photo"     =>  "required|image|max:3072",
            "buttonUrl" =>  "nullable|url"
        ]);

        Slide::create($request->photo, $request->title, $request->subtitle, $request->buttonText, $request->buttonUrl);

        return redirect("admin/website/slides");
    }

    public function deleteSlide($id)
    {
        $slide = Slide::findOrFail($id);
        $slide->delete();
        return redirect("admin/website/slides");
    }

    ///logo functions

    public function loadWebsiteLogo()
    {
        $data['info'] = SiteInfo::getSiteInfo()->WBST_LOGO;
        $data['formUrl'] = url('admin/website/logo/set');
        return view("settings.logo", $data);
    }

    public function setWebsiteLogo(Request $request)
    {
        $siteInfo = SiteInfo::getSiteInfo();
        $siteInfo->setLogo($request->logo);
        return redirect($this->homeURL);
    }

    public function loadWebsiteInfo()
    {
        $data['info'] = SiteInfo::getSiteInfo();
        $data['formUrl'] = url('admin/website/info/set');
        return view("settings.siteinfo", $data);
    }

    public function setWebsiteInfo(Request $request)
    {
        $request->validate([
            "logo" => "nullable|image|max:3072",
            "mail" => "nullable|email",
            "landingImage" => "nullable|image|max:3072",
            "footerLargeImg" => "nullable|image|max:3072",
            "phone" => "nullable|string",
        ]);

        $siteInfo = SiteInfo::getSiteInfo();
        $siteInfo->setSiteInfo(
            $request->logo,
            $request->mail,
            $request->landingImage,
            $request->footerLargeImg,
            $request->phone,
            $request->instagram,
            $request->fb,
            $request->footerImage1,
            $request->footerImage2,
            $request->footerImage3,
            $request->footerTitle1,
            $request->footerSubtitle1
        );
        return redirect($this->homeURL);
    }

    ///////////////////about us functions//////////////
    public function loadAboutus()
    {
        return view("settings.html_editor", $this->getHtmlEditorDataArr("Website Aboutus", "aboutus", SiteInfo::getSiteInfo()->aboutus));
    }

    public function setAboutus(Request $request)
    {
        $request->validate([
            "aboutus"   =>  "required"
        ]);
        $siteInfo = SiteInfo::getSiteInfo();
        $siteInfo->setAboutus($request->aboutus);
        return redirect("admin/website/aboutus");
    }

    ///////////////////delivery policy functions//////////////
    public function loadDeliveryPolicy()
    {
        return view("settings.html_editor", $this->getHtmlEditorDataArr("Delivery Policy", "delivery_policy", SiteInfo::getSiteInfo()->delivery_policy));
    }

    public function setDeliveryPolicy(Request $request)
    {
        $request->validate([
            "delivery_policy"   =>  "required"
        ]);
        $siteInfo = SiteInfo::getSiteInfo();
        $siteInfo->setDeliverPolicy($request->delivery_policy);
        return redirect("admin/website/delivery_policy");
    }

    ///////////////////payment policy functions//////////////
    public function loadPaymentPolicy()
    {
        return view("settings.html_editor", $this->getHtmlEditorDataArr("Payment Policy", "payment_policy", SiteInfo::getSiteInfo()->payment_policy));
    }

    public function setPaymentPolicy(Request $request)
    {
        $request->validate([
            "payment_policy"   =>  "required"
        ]);
        $siteInfo = SiteInfo::getSiteInfo();
        $siteInfo->setPaymentPolicy($request->payment_policy);
        return redirect("admin/website/payment_policy");
    }

    private function getHtmlEditorDataArr($formTitle, $inputName,  $inputValue,)
    {
        $data['formTitle'] = $formTitle;
        $data['inputName'] = $inputName;
        $data['inputValue'] = $inputValue;
        return $data;
    }
}
