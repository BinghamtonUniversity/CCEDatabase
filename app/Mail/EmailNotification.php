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
//                $email_content = [
//                    'contact'=>[
//                        'name'=>$obj->contact_name
//                    ],
//                    'organization'=>[
//                        'name'=>$obj->name
//                    ]
//                ];
                break;
            case 'org_updated':
                $this->email_conf = "updated.organization";
//                $email_content = [
//                    'contact'=>[
//                        'name'=>$obj->contact_name
//                    ],
//                    'organization'=>[
//                        'name'=>$obj->name
//                    ]
//                ];
                break;
            case 'org_approved':
                $this->email_conf = "approved.organization";
//                $email_content = [
//                    'contact'=>[
//                        'name'=>$obj->contact_name
//                    ],
//                    'listing'=>[
//                        'name'=>$obj->title
//                    ]
//                ];
                break;
            case 'listing_created':
                $this->email_conf = "created.listing";
//                $email_content = [
//                    'contact'=>[
//                        'name'=>$obj->contact_name
//                    ],
//                    'listing'=>[
//                        'name'=>$obj->title
//                    ]
//                ];
                break;
            case 'listing_updated':
                $this->email_conf = "updated.listing";
//                $email_content = [
//                    'contact'=>[
//                        'name'=>$obj->contact_name
//                    ],
//                    'listing'=>[
//                        'name'=>$obj->title
//                    ]
//                ];
                break;
            case 'listing_approved':
                $this->email_conf = "approved.listing";
//                $this->email_subject = config('email_templates.approved.listing.subject');
//                $email_content = [
//                    'contact'=>[
//                        'name'=>$obj->contact_name
//                    ],
//                    'listing'=>[
//                        'name'=>$obj->title
//                    ]
//                ];
                break;
            case 'password_update':
                $this->email_conf = "updated.password";
//                $email_content = [
//                    'contact'=>[
//                        'name'=>$obj->contact_name
//                    ],
//                    'organization'=>[
//                        'name'=>$obj->name
//                    ]
//                ];
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
        return $this->view('emails.email_raw')
            ->with(['content'=>$this->content])
            ->subject(config('email_templates.'.$this->email_conf.'.subject'));
    }
}
