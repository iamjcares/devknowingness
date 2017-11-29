<?php

namespace Knowingness\Libraries;

use Knowingness\Models\Order;
use Knowingness\Models\OrderItem;
use Knowingness\Models\PaymentSetting;
use Knowingness\Models\Enrolment;
use Auth;

class PayPalHelper
{

    public static function executePayment($options)
    {
        $user = Auth::user();
        $pid = $options['payment_id'];
        $payer = $options['payer_id'];
        $token = self::getToken();
        $order = Order::where('payment_id', $pid)->first();
        if (!is_array($token)) {
            return false;
        }
        $accessToken = $token['access_token'];

        $payment = PaymentSetting::first();
        $url = $payment->paypal_live_mode ? "https://api.live.paypal.com/v1/payments/payment/{$pid}/execute" : "https://api.sandbox.paypal.com/v1/payments/payment/{$pid}/execute";
        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $accessToken];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        $data = [
            'payer_id' => $payer,
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $res = json_decode(curl_exec($ch), true);
        // perform some completion processing here
        if ($res['state'] === 'approved') {
            $order->status = 'approved';
            $order->transaction_fee = $res['transactions'][0]['related_resources'][0]['sale']['transaction_fee']['value'];
            $order->save();
            $items = $order->items;

            foreach ($items as $i) {
                Enrolment::create([
                    'user_id' => $user->id,
                    'course_id' => $i->course_id,
                    'order_id' => $order->id,
                    'status' => 'new'
                ]);
            }
            self::clearCart();
        } else {

        }

        return $res;
    }

    public static function testOrder()
    {
        $order = Order::where('payment_id', 'PAY-2EL724873Y792510CLIOQ7MQ')->first();
        $items = $order->items;
        foreach ($items as $e) {
            echo $e->course_id . " - " . $e->price;
        }
    }

    public static function createPayment($options, $cart)
    {
        $user = Auth::user();
        $payment = PaymentSetting::first();
        // creating an order.
        $code = strtoupper(substr(hash('sha256', time()), 0, 30));
        $order = Order::create([
                    'user_id' => $user->id,
                    'code' => $code,
                    'status' => 'new',
                    'payment_method' => 'paypal',
        ]);

        if ($options['type'] === 'cart') {
            $cartItems = self::cartToItem($order, $cart);
        } else {
            $cartItems = self::courseToItem($order, $cart);
        }

        $token = self::getToken();
        if (!is_array($token)) {
            return false;
        }
        $accessToken = $token['access_token'];

        $url = $payment->paypal_live_mode ? 'https://api.live.paypal.com/v1/payments/payment' : 'https://api.sandbox.paypal.com/v1/payments/payment';
        $headers = ['Content-Type: application/json', 'Authorization: Bearer ' . $accessToken];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = [
            'intent' => 'sale',
            'redirect_urls' => ['return_url' => 'http://dev.knowingness/checkout/complete', 'cancel_url' => 'http://dev.knowingness/checkout/failed'],
            'payer' => [
                'payment_method' => 'paypal',
                'payer_info' => [
                    'email' => $user->email,
                    'first_name' => $user->name,
                    'last_name' => '',
                    'payer_id' => hash('md5', $user->email),
                ]
            ],
            'transactions' => [
                [
                    'amount' => [
                        'total' => $cartItems['subtotal'],
                        'currency' => 'USD',
                    ],
                    'item_list' => [
                        'items' => $cartItems['items'],
                    ],
                    'description' => 'Course Purchased on Knowingness.com',
                    'invoice_number' => $order->code,
                ]
            ],
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = json_decode(curl_exec($ch), true);

        // updating order
        $order->payment_id = $response['id'];
        $order->status = 'created';
        $order->save();

        return $response;
    }

    public static function getToken()
    {
        $payment = PaymentSetting::first();
        $url = $payment->paypal_live_mode ? 'https://api.live.paypal.com/v1/oauth2/token' : 'https://api.sandbox.paypal.com/v1/oauth2/token';
        $headers = ['Accept: application/json', 'Accept-Language: en_US',
            'Authorization: Basic ' . base64_encode("$payment->paypal_test_client_id:$payment->paypal_test_secret_key")];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        return json_decode(curl_exec($ch), true);
    }

    public static function cartToItem($order, $cart)
    {
        $response = [];
        $response['items'] = [];
        $subtotal = 0;
        $desc = 'Purchase : ';
        foreach ($cart->courses as $course) {
            $subtotal += $course->price;
            $desc .= $course->title;
            $c = [
                'quantity' => 1,
                'name' => $course->title,
                'price' => $course->price,
                'currency' => 'USD',
                'description' => $course->description,
            ];
            $response['items'][] = $c;

            OrderItem::create([
                'order_id' => $order->id,
                'course_id' => $course->id,
                'price' => $course->price,
            ]);
        }
        $response['subtotal'] = $subtotal;
        // update order.
        $order->description = $desc;
        $order->total = $subtotal;
        $order->save();
        return $response;
    }

    public static function courseToItem($order, $course)
    {
        $response = [];
        $response['items'] = [];
        $desc = 'Purchases : ' . $course->title;
        $c = [
            'quantity' => 1,
            'name' => $course->title,
            'price' => $course->price,
            'currency' => 'USD',
            'description' => $course->description,
        ];

        OrderItem::create([
            'order_id' => $order->id,
            'course_id' => $course->id,
            'price' => $course->price,
        ]);
        $response['items'][] = $c;
        $response['subtotal'] = $course->price;
        // update order.
        $order->description = $desc;
        $order->total = $subtotal;
        $order->save();

        return $response;
    }

    public static function clearCart()
    {
        $cart = \Knowingness\Models\Cart::with(['courses'])->where([['user_id', '=', Auth::user()->id], ['instance', '=', 'cart']])->first();
        $cart->courses()->sync([]);
    }

}
