<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ユーザーのIDを元にこれまで追加したカートの中身を$cart変数に保存
        $cart = Cart::instance(Auth::user()->id)->content();

        $total = 0;
        $has_carriage_cost = false;
        $carriage_cost = 0;

        foreach ($cart as $c) {
            $total += $c->qty * $c->price; //$total=カートの中の全商品の合計額
            if($c->options->carriage){
                $has_carriage_cost = true;
            }
        }

        if ($has_carriage_cost) {
            $total += env('CARRIAGE');//$total=カートの中の全商品の合計額+（送料が必要なら）送料
            $carriage_cost = env('CARRIAGE');
        }

        return view('carts.index', compact('cart', 'total','carriage_cost'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ユーザーのIDを元にカートのデータを作成し、add()関数を使って送信されたデータを元に商品を追加しています。
        Cart::instance(Auth::user()->id)->add(
            [
                'id' => $request->id,
                'name' => $request->name,
                'qty' => $request->qty,
                'price' => $request->price,
                'weight' => $request->weight,
                'options' => [
                    'image' => $request->image,
                    'carriage' => $request->carriage,
                ]
            ]
        );

        return to_route('products.show', $request->get('id'));
    }



}
