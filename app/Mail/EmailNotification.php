<?php

namespace App\Mail;

use App\Organization;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    private $content;
    private $email_subject;
    /**
     * @var string
     */
    private $email_conf;

    /**
     * Create a new message instance.
     *
     * @param $userMessage
     * @param $type
     * @param $obj
     */
    public function __construct($obj, $type)
    {

        $m = new \Mustache_Engine;


        switch ($type) {
            case 'org_created':
                $this->email_conf = "created.organization";
                break;
            case 'org_updated':
                $this->email_conf = "updated.organization";
                break;
            case 'org_approved':
                $this->email_conf = "approved.organization";
                break;
            case 'listing_created':
                $this->email_conf = "created.listing";
                break;
            case 'listing_updated':
                $this->email_conf = "updated.listing";
                break;
            case 'listing_approved':
                $this->email_conf = "approved.listing";
                break;
            case 'listing_contact':
                $this->email_conf = "contact_form.listing";
                break;
            case 'org_contact':
                $this->email_conf = "contact_form.organization";
                break;
            case 'listing_user_message':
                $this->email_conf = "contact_form.email_from_student_received.listing";
                $this->replyToAddress = $obj['replyTo'];
                break;
            case 'org_user_message':
                $this->email_conf = "contact_form.email_from_student_received.organization";
                $this->replyToAddress = $obj['replyTo'];
                break;
            case 'password_update':
                $this->email_conf = "updated.password";
                break;
            case 'password_reset':
                $this->email_conf = "reset.password";
                break;
            default:
                $this->email_conf="default";
                $email_content = [];
        }

        $this->content = $m->render(config('email_templates.'.$this->email_conf.'.body'),$obj);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(isset($this->replyToAddress)){
            return $this->view('emails.email_raw')
                ->replyTo($this->replyToAddress)
                ->with(['content'=>$this->content])
                ->subject(config('email_templates.'.$this->email_conf.'.subject'));
        }
        else{
            return $this->view('emails.email_raw')
                ->with(['content'=>$this->content])
                ->subject(config('email_templates.'.$this->email_conf.'.subject'));
        }

    }
}
