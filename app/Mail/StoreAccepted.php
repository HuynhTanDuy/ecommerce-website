<?php

namespace App\Mail;

use App\Store;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StoreAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $store;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $owner = User::where('id',$this->store->id_owner)->first();
        return $this->to($owner->email, $owner->name)
                    ->bcc('another@another.com')
                    ->subject('Cửa hàng của bạn đã được xét duyệt thành công')
                    ->markdown('emails.store.accepted');
    }
}
