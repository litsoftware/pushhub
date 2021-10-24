<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifierMail extends Mailable
{
    use SerializesModels;

    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($subject = data_get($this->data, 'subject')) {
            $this->subject($subject);
        }

        $view = data_get($this->data, 'view', 'mail.default');
        $params = array_merge([
            'content' =>data_get($this->data, 'content', ''),
        ], data_get($this->data, 'params', []));

        return $this->view($view, compact('params'));
    }
}
