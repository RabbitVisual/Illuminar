<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\Models\EmailTemplate;

class NotificationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'mailable_class' => EmailTemplate::MAILABLE_PAYMENT_APPROVED,
                'subject' => 'Illuminar - Pagamento confirmado - Pedido #{order_number}',
                'body' => "Olá, {customer_name}!\n\nSeu pagamento foi confirmado e estamos preparando seu pedido #{order_number}.\n\n**Total:** {order_total}\n\nAcompanhe seu pedido pelo painel do cliente. Qualquer dúvida, estamos à disposição.",
                'is_active' => true,
            ],
            [
                'mailable_class' => EmailTemplate::MAILABLE_ORDER_SHIPPED,
                'subject' => 'Illuminar - Seu pedido #{order_number} foi enviado',
                'body' => "Olá, {customer_name}!\n\nSeu pedido #{order_number} foi enviado.\n\n**Código de rastreio:** {tracking_code}\n**Transportadora:** {shipping_method}\n\nAcompanhe a entrega pelo link de rastreamento. Obrigado por comprar conosco!",
                'is_active' => true,
            ],
        ];

        foreach ($templates as $data) {
            EmailTemplate::updateOrCreate(
                ['mailable_class' => $data['mailable_class']],
                $data
            );
        }
    }
}
