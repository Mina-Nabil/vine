<?php

namespace App\Mail;

use App\Models\SiteInfo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ForgetPass extends Mailable
{
    use Queueable, SerializesModels;

    public $forgetpassUrl;
    public $logo;
    public $infoMail;
    public $instagramUrl;
    public $fbUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($forgetpassUrl)
    {
        $this->forgetpassUrl = $forgetpassUrl;
        $this->infoMail = env("MAIL_FROM_ADDRESS=info@getwhalewear.com
        ", "info@getwhalewear.com");
        $siteInfo = SiteInfo::getSiteInfo();
        $this->logo = $siteInfo->getLogoUrlAttribute();
        $this->instagramUrl = $siteInfo->getInstaUrlAttribute();
        $this->fbUrl = $siteInfo->getFbUrlAttribute();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.forgetpass');
    }
}
