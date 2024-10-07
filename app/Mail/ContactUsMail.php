<?php

namespace App\Mail;

use App\Models\SiteInfo;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;


    public $sender_name;
    public $sender_email;
    public $sender_number;
    public $sender_msg;

    public $logo;
    public $infoMail;
    public $instagramUrl;
    public $fbUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sender_name, $sender_email, $sender_number, $sender_msg)
    {
        $this->sender_name = $sender_name;
        $this->sender_email = $sender_email;
        $this->sender_number = $sender_number;
        $this->sender_msg = $sender_msg;
        $this->infoMail = env("INFO_MAIL_ADDRESS", "info@egkemet.com

        ");
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
        $data = array();
        $data['sender_name'] = $this->sender_name;
        $data['sender_email'] = $this->sender_email;
        $data['sender_number'] = $this->sender_number;
        $data['sender_msg'] = $this->sender_msg;
        $data['logo'] = $this->logo;
        $data['infoMail'] = $this->infoMail;
        $data['instagramUrl'] = $this->instagramUrl;
        $data['fbUrl'] = $this->fbUrl;

        return $this->view('emails.contactusmsg', $data);
    }
}
