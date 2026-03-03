<?php

namespace Modules\Notification\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Sales\Models\Order;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Optional custom subject (when sending from template). If null, uses default.
     */
    public ?string $customSubject = null;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Order $order,
        public string $title,
        public string $messageBody,
        ?string $subject = null
    ) {
        $this->customSubject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->customSubject ?? ('Illuminar - Seu pedido #' . $this->order->order_number);

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'notification::emails.order-status',
        );
    }
}
