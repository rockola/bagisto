@component('admin::emails.layouts.master')
    <div style="text-align: center;">
        <a href="{{ config('app.url') }}">
            <img src="{{ bagisto_asset('vendor/webkul/shop/assets/images/logo.svg') }}">
        </a>
    </div>

    <?php $order = $invoice->order; ?>

    <div style="padding: 30px;">
        <div style="font-size: 20px;color: #242424;line-height: 30px;margin-bottom: 34px;">
            <span style="font-weight: bold;">
                {{ __('admin::app.mail.invoice.heading', ['order_id' => $order->id, 'invoice_id' => $invoice->id]) }}
            </span> <br>

            <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
                {{ __('admin::app.mail.order.dear', ['customer_name' => $order->customer_full_name]) }},
            </p>

            <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
                {!! __('admin::app.mail.order.greeting', [
                    'order_id' => '<a href="' . route('customer.orders.view', $order->id) . '" style="color: #0041FF; font-weight: bold;">#' . $order->id . '</a>',
                    'created_at' => $order->created_at
                    ]) 
                !!}
            </p>
        </div>

        <div style="font-weight: bold;font-size: 20px;color: #242424;line-height: 30px;margin-bottom: 20px !important;">
            {{ __('admin::app.mail.invoice.summary') }}
        </div>

        <div style="display: flex;flex-direction: row;margin-top: 20px;justify-content: space-between;margin-bottom: 40px;">
            <div style="line-height: 25px;">
                <div style="font-weight: bold;font-size: 16px;color: #242424;">
                    {{ __('admin::app.mail.order.shipping-address') }}
                </div>

                <div>
                    {{ $order->shipping_address->name }}
                </div>

                <div>
                    {{ $order->shipping_address->address1 }}, {{ $order->shipping_address->address2 ? $order->shipping_address->address2 . ',' : '' }} {{ $order->shipping_address->state }}
                </div>

                <div>
                    {{ country()->name($order->shipping_address->country) }} {{ $order->shipping_address->postcode }}
                </div>

                <div>---</div>

                <div style="margin-bottom: 40px;">
                    {{ __('admin::app.mail.order.contact') }} : {{ $order->shipping_address->phone }} 
                </div>

                <div style="font-size: 16px;color: #242424;">
                    {{ __('admin::app.mail.order.shipping') }}
                </div>

                <div style="font-weight: bold;font-size: 16px;color: #242424;">
                    {{ $order->shipping_title }}
                </div>
            </div>

            <div style="line-height: 25px;">
                <div style="font-weight: bold;font-size: 16px;color: #242424;">
                    {{ __('admin::app.mail.order.billing-address') }}
                </div>

                <div>
                    {{ $order->billing_address->name }}
                </div>

                <div>
                    {{ $order->billing_address->address1 }}, {{ $order->billing_address->address2 ? $order->billing_address->address2 . ',' : '' }} {{ $order->billing_address->state }}
                </div>

                <div>
                    {{ country()->name($order->billing_address->country) }} {{ $order->billing_address->postcode }}
                </div>

                <div>---</div>

                <div style="margin-bottom: 40px;">
                    {{ __('admin::app.mail.order.contact') }} : {{ $order->billing_address->phone }} 
                </div>

                <div style="font-size: 16px; color: #242424;">
                    {{ __('admin::app.mail.order.payment') }}
                </div>

                <div style="font-weight: bold;font-size: 16px; color: #242424;">
                    {{ core()->getConfigData('paymentmethods.' . $order->payment->method . '.title') }}
                </div>
            </div>
        </div>

        @foreach ($invoice->items as $item)
            <div style="background: #FFFFFF;border: 1px solid #E8E8E8;border-radius: 3px;padding: 20px">
                <p style="font-size: 18px;color: #242424;line-height: 24px;margin-top: 0;margin-bottom: 10px;font-weight: bold;">
                    {{ $item->name }}
                </p>

                <div style="margin-bottom: 10px;">
                    <label style="font-size: 16px;color: #5E5E5E;">
                        {{ __('admin::app.mail.order.price') }}
                    </label>
                    <span style="font-size: 18px;color: #242424;margin-left: 40px;font-weight: bold;">
                        {{ core()->formatPrice($item->price, $invoice->order_currency_code) }}
                    </span>
                </div>

                <div style="margin-bottom: 10px;">
                    <label style="font-size: 16px;color: #5E5E5E;">
                        {{ __('admin::app.mail.order.quantity') }}
                    </label>
                    <span style="font-size: 18px;color: #242424;margin-left: 40px;font-weight: bold;">
                        {{ $item->qty }}
                    </span>
                </div>
                
                <div style="">
                    <label style="margin-top: 10px; font-size: 16px;color: #5E5E5E; display: block;">
                        Color : Gray, Size  : S
                    </label>
                </div>
            </div>
        @endforeach

        <div style="font-size: 16px;color: #242424;line-height: 30px;float: right;width: 40%;margin-top: 20px;">
            <div>
                <span>{{ __('admin::app.mail.order.subtotal') }}</span>
                <span style="float: right;">
                    {{ core()->formatPrice($invoice->sub_total, $invoice->order_currency_code) }}
                </span>
            </div>

            <div>
                <span>{{ __('admin::app.mail.order.shipping-handling') }}</span>
                <span style="float: right;">
                    {{ core()->formatPrice($invoice->shipping_amount, $invoice->order_currency_code) }}
                </span>
            </div>

            <div>
                <span>{{ __('admin::app.mail.order.tax') }}</span>
                <span style="float: right;">
                    {{ core()->formatPrice($invoice->tax_amount, $invoice->order_currency_code) }}
                </span>
            </div>

            <div style="font-weight: bold">
                <span>{{ __('admin::app.mail.order.grand-total') }}</span>
                <span style="float: right;">
                    {{ core()->formatPrice($invoice->grand_total, $invoice->order_currency_code) }}
                </span>
            </div>
        </div>

        <div style="margin-top: 65px;font-size: 16px;color: #5E5E5E;line-height: 24px;display: inline-block;width: 100%">
            <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
                {!! 
                    __('admin::app.mail.order.help', [
                        'support_email' => '<a style="color:#0041FF" href="mailto:' . config('mail.from.address') . '">' . config('mail.from.address'). '</a>'
                        ]) 
                !!}
            </p>

            <p style="font-size: 16px;color: #5E5E5E;line-height: 24px;">
                {{ __('admin::app.mail.order.thanks') }}
            </p>
        </div>
    </div>
@endcomponent