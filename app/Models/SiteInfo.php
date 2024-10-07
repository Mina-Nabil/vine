<?php

namespace App\Models;

use App\Services\FileManager;
use Exception;
use Illuminate\Database\Eloquent\Model;

class SiteInfo extends Model
{
    protected $table = "website_info";
    public $timestamps = false;

    //queries
    public static function getSiteInfo(): SiteInfo
    {
        $ret = self::first();
        if ($ret != null) {
            return $ret;
        } else {
            $ret = new SiteInfo();
            $ret->save();
            return $ret;
        }
    }

    public function setSiteInfo($logo = null, $mail, $offerSmallImg = null, $offerLargeImg = null, $phone, $instagram, $fb, $footerImage1 = null, $footerImage2 = null, $footerTitle1, $footerTitle2, $footerSubtitle1, $footerSubtitle2)
    {
        $this->WBST_MAIL = $mail;
        $this->WBST_PHON = $phone;
        $this->WBST_INST = $instagram;
        $this->WBST_FB = $fb;
        $this->WBST_FOOT_TTL1 = $footerTitle1;
        $this->WBST_FOOT_TTL2 = $footerTitle2;
        $this->WBST_FOOT_SUB1 = $footerSubtitle1;
        $this->WBST_FOOT_SUB2 = $footerSubtitle2;

        if ($logo != null) {
            $oldLogo = $this->WBST_LOGO;
            $this->WBST_LOGO = FileManager::save($logo, "logo");
        }

        if ($offerLargeImg != null) {
            $oldOfferLargeImg = $this->WBST_OFFR_STRP_LARG;
            $this->WBST_OFFR_STRP_LARG = FileManager::save($offerLargeImg, "offers");
        }

        if ($offerSmallImg != null) {
            $oldOfferSmallImg = $this->WBST_OFFR_STRP_SMAL;
            $this->WBST_OFFR_STRP_SMAL = FileManager::save($offerSmallImg, "offers");
        }

        if ($footerImage1 != null) {
            $oldFooterImage1 = $this->WBST_FOOT_IMG1;
            $this->WBST_FOOT_IMG1 = FileManager::save($footerImage1, "footers");
        }

        if ($footerImage2 != null) {
            $oldFooterImage2 = $this->WBST_FOOT_IMG2;
            $this->WBST_FOOT_IMG2 = FileManager::save($footerImage2, "footers");
        }


        try {
            $this->save();
            if (isset($oldLogo)) FileManager::delete($oldLogo);
            if (isset($oldOfferSmallImg)) FileManager::delete($oldOfferSmallImg);
            if (isset($oldOfferLargeImg)) FileManager::delete($oldOfferLargeImg);
            if (isset($oldFooterImage1)) FileManager::delete($oldFooterImage1);
            if (isset($oldFooterImage2)) FileManager::delete($oldFooterImage2);
        } catch (Exception $e) {
            if ($logo != null) FileManager::delete($logo);
            if ($offerLargeImg != null) FileManager::delete($offerLargeImg);
            if ($offerSmallImg != null) FileManager::delete($offerSmallImg);
            if ($footerImage1 != null) FileManager::delete($footerImage1);
            if ($footerImage2 != null) FileManager::delete($footerImage2);
        }
    }


    public function setAboutus($aboutus)
    {
        $this->WBST_ABUT = $aboutus;
        $this->save();
    }

    public function setPaymentPolicy($paymentPolicy)
    {
        $this->WBST_PPOL = $paymentPolicy;
        $this->save();
    }

    public function setDeliverPolicy($deliveryPolicy)
    {
        $this->WBST_DPOL = $deliveryPolicy;
        $this->save();
    }

    public function setLogo($logo = null)
    {
        $this->WBST_LOGO = $logo;
        if ($logo != null) {
            $oldLogo = $this->WBST_LOGO;
            $this->WBST_LOGO = FileManager::save($logo, "logo");
            if ($this->save()) {
                if (isset($oldLogo)) FileManager::delete($oldLogo);
            } else {
                if ($logo) FileManager::delete($logo);
            }
        }
    }

    public function setContactInfo($mail = null, $phone = null, $instagram = null, $fb = null,)
    {
    }

    public function setWebsiteImages($offerSmallImg = null, $offerLargeImg = null, $footerImage1 = null, $footerImage2 = null)
    {
    }

    ///////Accessors
    public function getEmailAttribute()
    {
        return $this->WBST_MAIL;
    }

    public function getPhoneAttribute()
    {
        return $this->WBST_PHON;
    }

    public function getLogoUrlAttribute()
    {
        return FileManager::get($this->WBST_LOGO);
    }

    public function getAboutusAttribute()
    {
        return $this->WBST_ABUT;
    }

    public function getDeliveryPolicyAttribute()
    {
        return $this->WBST_DPOL;
    }

    public function getPaymentPolicyAttribute()
    {
        return $this->WBST_PPOL;
    }

    public function getOfferSmallUrlAttribute()
    {
        return FileManager::get($this->WBST_OFFR_STRP_SMAL) ?? asset('frontend/placeholders/strip_small.png');
    }

    public function getOfferLargeUrlAttribute()
    {
        return FileManager::get($this->WBST_OFFR_STRP_LARG) ?? asset('frontend/placeholders/strip_square.png');
    }

    public function getOfferUrlAttribute()
    {
        return $this->WBST_OFFR_URL;
    }

    public function getFooter1UrlAttribute()
    {
        return FileManager::get($this->WBST_FOOT_IMG1) ?? asset('frontend/placeholders/footers.png');
    }

    public function getFooter1TitleAttribute()
    {
        return $this->WBST_FOOT_TTL1; //?? "Footer1 Title";
    }

    public function getFooter1SubtitleAttribute()
    {
        return $this->WBST_FOOT_SUB1; //?? "Footer1 Subtitle";;
    }

    public function getFooter2UrlAttribute()
    {
        return FileManager::get($this->WBST_FOOT_IMG2) ?? asset('frontend/placeholders/footers.png');
    }

    public function getFooter2TitleAttribute()
    {
        return $this->WBST_FOOT_TTL2; //?? "Footer2 Title";
    }

    public function getFooter2SubtitleAttribute()
    {
        return $this->WBST_FOOT_SUB2; //?? "Footer2 Subtitle";;
    }

    public function getFbUrlAttribute()
    {
        return $this->WBST_FB ? "https://www.facebook.com/" . $this->WBST_FB : null;
    }

    public function getInstaUrlAttribute()
    {
        return $this->WBST_INST ? "https://www.instagram.com/" . $this->WBST_INST : null;
    }
}
