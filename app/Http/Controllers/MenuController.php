<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $menu = Menu::all();

        return view('home', compact('menu'));
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
    public function store($id, Request $request)
    {
        $userID = 1213123435;
        $database = app('firebase.database');
        $saved = Menu::find($id);
        $umkmID = $saved->umkm_id;
        $id = $saved->id;
        $jumlah = $request->input('quantity_hidden');
        //$existingUmkmID = $database->getReference('cart/' . $userID)->getSnapshot()->exists();
        $existingUmkmID = $database->getReference('cart/' . $userID . '/orders')->getSnapshot()->exists();
        $postData = [
            'id' => $id,
            'nama' => $saved->nama,
            'harga' => $saved->harga,
            'umkm_id' => $saved->umkm_id,
            'jumlah' => $jumlah,
        ];

        if ($existingUmkmID) {
            $currentUmkmID = $database->getReference('cart/' . $userID . '/orders' . '/item1' . '/umkm_id')->getValue();
            if ($currentUmkmID != $umkmID) {
                $database->getReference('cart/' . $userID . '/orders')->remove();
                $postRef = $database->getReference('cart/' . $userID . '/orders' . '/item1')->set($postData);
            } else {
                $itemCount = $database->getReference('cart/' . $userID . '/orders')->getSnapshot()->numChildren();
                $itemNumber = $itemCount + 1;
                $item = 'item' . $itemNumber;
                $i = 1;
                $checkid = $database->getReference('cart/' . $userID . '/orders' . '/item' . $i . '/id')->getValue();
                while ($i <= $itemCount && $checkid != $id) {
                    $i++;
                    $checkid = $database->getReference('cart/' . $userID . '/orders' . '/item' . $i . '/id')->getValue();
                }
                if ($checkid == $id) {
                    $postRef = $database->getReference('cart/' . $userID . '/orders' . '/item' . $i . '/jumlah')->set($jumlah);
                } else {
                    $postRef = $database->getReference('cart/' . $userID . '/orders' . '/' . $item)->set($postData);
                }
            }
        } else {
            //$database->getReference('cart/' . $userID)->remove();
            $postRef = $database->getReference('cart/' . $userID . '/orders' . '/item1')->set($postData);
        }
        $count = $database->getReference('cart/' . $userID . '/orders')->getSnapshot()->numChildren();
        $j = 1;
        $total = 0;
        while ($j <= $count) {
            $pricePerItem = $database->getReference('cart/' . $userID . '/orders' . '/item' . $j . '/harga')->getValue();
            $quantityPerItem = $database->getReference('cart/' . $userID . '/orders' . '/item' . $j . '/jumlah')->getValue();
            $currentTotal = $pricePerItem * $quantityPerItem;
            $total += $currentTotal;
            $j++;
        }
        $postTotal =
            $database->getReference('cart/' . $userID . '/total')->set($total);
        if ($postTotal) {
            return redirect('/')->with('status', 'success');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
