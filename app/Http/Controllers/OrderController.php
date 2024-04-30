<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userID = 1213123435;
        $database = app('firebase.database');
        $data = $database->getReference('cart/' . $userID . '/orders')->getValue();
        $total = $database->getReference('cart/' . $userID . '/total')->getValue();

        //dd($data);

        return view('orders', compact('data', 'total'));
    }

    public function tambahJumlah(Request $request)
    {
        $userID = 1213123435;
        $database = app('firebase.database');

        $idBarang = $request->input('id');
        $kuantitasAwal = $request->input('kuantitas_awal');

        $itemCount = $database->getReference('cart/' . $userID . '/orders')->getSnapshot()->numChildren();
        $i = 1;

        while ($i <= $itemCount) {
            $item = 'item' . $i;
            $id = $database->getReference('cart/' . $userID . '/orders' . '/' . $item . '/id')->getValue();
            if ($id == $idBarang) {
                $kuantitasBaru = $kuantitasAwal + 1;
                $database->getReference('cart/' . $userID . '/orders' . '/' . $item . '/jumlah')->set($kuantitasBaru);
                $total = $this->calculateTotalPrice($userID);
                $database->getReference('cart/' . $userID . '/total')->set($total);
                return response()->json([
                    'kuantitas_baru' => $kuantitasBaru,
                    'totalHarga' => $total,
                ]);
                break;
            }
            $i++;
        }
    }

    private function calculateTotalPrice($userID)
    {
        $database = app('firebase.database');
        $total = 0;
        $itemCount = $database->getReference('cart/' . $userID . '/orders')->getSnapshot()->numChildren();
        $i = 1;
        while ($i <= $itemCount) {
            $pricePerItem = $database->getReference('cart/' . $userID . '/orders' . '/item' . $i . '/harga')->getValue();
            $quantityPerItem = $database->getReference('cart/' . $userID . '/orders' . '/item' . $i . '/jumlah')->getValue();
            $currentTotal = $pricePerItem * $quantityPerItem;
            $total += $currentTotal;
            $i++;
        }

        return $total;
    }

    public function kurangJumlah(Request $request)
    {
        $userID = 1213123435;
        $database = app('firebase.database');

        $idBarang = $request->input('id');
        $kuantitasAwal = $request->input('kuantitas_awal');

        $itemCount = $database->getReference('cart/' . $userID . '/orders')->getSnapshot()->numChildren();
        $i = 1;

        while ($i <= $itemCount) {
            $item = 'item' . $i;
            $id = $database->getReference('cart/' . $userID . '/orders' . '/' . $item . '/id')->getValue();
            if ($id == $idBarang) {
                $kuantitasBaru = $kuantitasAwal - 1;
                $database->getReference('cart/' . $userID . '/orders' . '/' . $item . '/jumlah')->set($kuantitasBaru);
                $total = $this->calculateTotalPrice($userID);
                $database->getReference('cart/' . $userID . '/total')->set($total);
                return response()->json([
                    'kuantitas_baru' => $kuantitasBaru,
                    'totalHarga' => $total,
                ]);
                break;
            }
            $i++;
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userID = 1213123435;
        $database = app('firebase.database');

        $itemCount = $database->getReference('cart/' . $userID . '/orders')->getSnapshot()->numChildren();
        $deletedIndex = null;

        // Find the index of the item to be deleted
        for ($i = 1; $i <= $itemCount; $i++) {
            $ref = $database->getReference('cart/' . $userID . '/orders' . '/item' . $i . '/id')->getValue();
            if ($id == $ref) {
                $deletedIndex = $i;
                break;
            }
        }

        if ($deletedIndex !== null) {
            $database->getReference('cart/' . $userID . '/orders' . '/item' . $deletedIndex)->remove();

            // Shift the indices of subsequent items
            for ($j = $deletedIndex + 1; $j <= $itemCount; $j++) {
                $item = $database->getReference('cart/' . $userID . '/orders' . '/item' . $j)->getValue();
                $database->getReference('cart/' . $userID . '/orders' . '/item' . ($j - 1))->set($item);
                // Remove the last item
                if ($j === $itemCount) {
                    $database->getReference('cart/' . $userID . '/orders' . '/item' . $j)->remove();
                }
            }
            $total = $this->calculateTotalPrice($userID);
            $database->getReference('cart/' . $userID . '/total')->set($total);
            // Update the total price

        }

        return redirect('/orders')->with('status', 'success');
    }
}
