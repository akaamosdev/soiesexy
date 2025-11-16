<?php

namespace App\Http\Controllers;

use App\Jobs\MailSendJob;
use App\Mail\SendMail;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $addr=Address::query()->create([
            "name"=>$request->get('name'),
            "phone"=>$request->get('phone'),
            "address"=>$request->get('address'),
            "frais"=>$request->get('frais'),
        ]);
        $order=Order::query()->create([
            "address_id"=>$addr->id,
            "code"=>time(),
            "montant"=>$request->get('montant'),
            "status"=>"pending",
        ]);
        foreach($request->get('items') as $item){
            OrderItem::query()->create([
                "order_id"=>$order->id,
                "product_id"=>$item['product_id'],
                "quantity"=>$item['quantity'],
                "price"=>$item['price'],
                "taille_id"=>$item['taille_id'],
                "color_id"=>$item['color_id'],
                "montant"=>$item['price']*$item['quantity'],
            ]);
        }
        MailSendJob::dispatch($order);
        return response()->json(['statut'=>true,"message"=>"Nous avons bien reçu votre commande ! Merci pour la confiance"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
