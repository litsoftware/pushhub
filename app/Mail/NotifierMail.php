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
        if (!$this->data['tmplId']) {
            return $this->view('mail.default', [
                'content' => $this->data['content']
            ]);
        } else {
            $params = $this->data['params'];
            return $this->view($this->data['tmplId'], compact('params'));
        }
    }
}
