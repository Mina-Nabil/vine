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

    public function setSiteInfo(
        $logo,
        $mail,
        $landingPhoto,
        $largeFooter,
        $phone,
        $instagram,
        $fb,
        $footerImage1,
        $footerImage2,
        $footerImage3,
        $footerTitle,
        $footerSubtitle
    ) {
        $this->WBST_MAIL = $mail;
        $this->WBST_PHON = $phone;
        $this->WBST_INST = $instagram;
        $this->WBST_FB = $fb;
        $this->WBST_FOOT_TTL = $footerTitle;
        $this->WBST_FOOT_SUB = $footerSubtitle;

        if ($logo != null) {
            $oldLogo = $this->WBST_LOGO;
            $this->WBST_LOGO = FileManager::save($logo, "logo");
        }

        if ($landingPhoto != null) {
            $oldLandingPhoto = $this->WBST_LAND;
            $this->WBST_LAND = FileManager::save($landingPhoto, "offers");
        }

        if ($largeFooter != null) {
            $oldLargeFooter = $this->WBST_FOOT_LRG;
            $this->WBST_FOOT_LRG = FileManager::save($largeFooter, "offers");
        }

        if ($footerImage1 != null) {
            $oldFooterImage1 = $this->WBST_FOOT_IMG1;
            $this->WBST_FOOT_IMG1 = FileManager::save($footerImage1, "footers");
        }
        if ($footerImage2 != null) {
            $oldFooterImage2 = $this->WBST_FOOT_IMG2;
            $this->WBST_FOOT_IMG2 = FileManager::save($footerImage2, "footers");
        }
        if ($footerImage3 != null) {
            $oldFooterImage3 = $this->WBST_FOOT_IMG3;
            $this->WBST_FOOT_IMG3 = FileManager::save($footerImage3, "footers");
        }


        try {
            $this->save();
            if (isset($oldLogo)) FileManager::delete($oldLogo);
            if (isset($oldLandingPhoto)) FileManager::delete($oldLandingPhoto);
            if (isset($oldFooterImage1)) FileManager::delete($oldFooterImage1);
            if (isset($oldFooterImage2)) FileManager::delete($oldFooterImage2);
            if (isset($oldFooterImage3)) FileManager::delete($oldFooterImage3);
            if (isset($oldLargeFooter)) FileManager::delete($oldLargeFooter);
        } catch (Exception $e) {
            if ($logo != null) FileManager::delete($logo);
            if ($landingPhoto != null) FileManager::delete($landingPhoto);
            if ($footerImage1 != null) FileManager::delete($landingPhoto);
            if ($footerImage2 != null) FileManager::delete($landingPhoto);
            if ($footerImage3 != null) FileManager::delete($landingPhoto);
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

    public function getLandingImageAttribute()
    {
        return FileManager::get($this->WBST_LAND) ?? url('assets/img/backgrounds/hero-bg.jpg');
    }

    public function getFooterLargeAttribute()
    {
        return FileManager::get($this->WBST_FOOT_LRG) ?? asset('frontend/placeholders/strip_square.png');
    }

    public function getFooter1UrlAttribute()
    {
        return FileManager::get($this->WBST_FOOT_IMG1) ?? asset('assets/img/journal/8.jpg');
    }

    public function getFooter2UrlAttribute()
    {
        return FileManager::get($this->WBST_FOOT_IMG2) ?? asset('assets/img/journal/8.jpg');
    }

    public function getFooter3UrlAttribute()
    {
        return FileManager::get($this->WBST_FOOT_IMG3) ?? asset('assets/img/journal/8.jpg');
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
