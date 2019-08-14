<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class ChargeController extends Controller
{
    /*単発決済用のコード*/
    public function charge(Request $request)
    {
        try {
            Stripe::setApiKey('sk_test_pVUxs7fuQ3MbjMDt6ZYPtlq100yl4Yjf1i');

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => 1000,
                'currency' => 'jpy'
            ));

            return back();
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function connectcharge(){
        $user = User::all()->where('stripe_user_id', '!==', "");
        return view('charge')->with('user',$user);
    }

    public function onecharge(Request $request){//connect charge
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));

            $iddata = $request->iddata;
            $postuser = User::find($iddata);
            $acct = $postuser->stripe_user_id;

            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));

            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => 1000,
                'currency' => 'jpy',
                "transfer_group" => "{ORDER10}",//グループ作成できる
                "metadata" => array("order_id" => "6735"),//メダデータ作成
                "destination" => array(//これを付けると子アカウントへ入金する
                  "amount" => 400,
                  "account" => $acct,//入金先のユーザーのid
                ),
            ));

            return 'Charge successful';
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }
    }
    public function eventget(Request $request){//購入先ユーザーのdestinationを指定しなければいけない

           Stripe::setApiKey(env('STRIPE_SECRET'));
           $result = $request["data"]["object"]["lines"]["data"][0]["metadata"]["destination"];

         \Stripe\Transfer::create(array(
           "amount" => 200,
           "currency" => "jpy",
           "destination" => $result,
           "transfer_group" => "{ORDER10}",
           "metadata" => array("destination" => "6735")
         ));
    }
}