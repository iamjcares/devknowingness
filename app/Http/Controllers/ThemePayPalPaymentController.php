<?php

namespace Knowingness\Http\Controllers;

use Knowingness\Libraries\PayPalHelper;
use Input;
use Auth;
use Knowingness\Models\Cart;
use Knowingness\User;

class ThemePayPalPaymentController extends BaseController
{

    public function __construct()
    {
        $this->middleware('secure');
    }

    public function createPayment()
    {
        $data = PayPalHelper::createPayment(['type' => 'cart'], $this->getCart());
        return response()->json($data, 200);
    }

    public function createBuyPayment()
    {
        $data = PayPalHelper::createPayment(['user' => $id], $this->getCart($id));
        return response()->json($data, 200);
    }

    public function executePayment()
    {
        $data = Input::all();
        $res = PayPalHelper::executePayment(['payer_id' => $data['payerID'], 'payment_id' => $data['paymentID']]);
        return response()->json($res, 200);
    }

    public function getCart()
    {
        return Cart::with(['courses'])->where([['user_id', '=', Auth::user()->id], [ 'instance', '=', 'cart']])->first();
    }

    public function testOrder()
    {
        PayPalHelper::testOrder();
        return;
    }

}
