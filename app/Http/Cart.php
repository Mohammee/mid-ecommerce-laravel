<?php

namespace App\Http;

class Cart
{

    public $qty;
    public $total;
    public $items;

    public function __construct($oldCart)
    {
        if(! empty($oldCart))
        {
            $this->total = $oldCart->total;
            $this->qty = $oldCart->qty;
            $this->items = $oldCart->items;
        }
    }

    public function addToCart($item)
    {
        $id = $item->id;
        $sortedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $sortedItem = $this->items[$id];
            }
        }

        $sortedItem['qty']++;
        $sortedItem['price'] = $sortedItem['qty'] * $item->price;
        $this->items[$id] = $sortedItem;

        $this->qty++;
        $this->total += $item->price;
    }

    public function update($item , $qty)
    {
        $id = $item->id;
        $oldQty = $this->items[$id]['qty'];
        $oldPrice = $this->items[$id]['price'];

        //total price without this item
        $this->total -= $oldPrice;
        $this->qty -= $oldQty;

        //new qty
        $this->items[$id]['qty'] = $qty ;

        //new price for this item
        $this->items[$id]['price'] = $qty * $item->price;

        //total price after update
        $this->total += $this->items[$id]['price'];
        $this->qty += $qty;

    }

    public function removeItem($id)
    {
        $this->qty -= $this->items[$id]['qty'];
        $this->total -= $this->items[$id]['price'];

        unset($this->items[$id]);
    }


}
