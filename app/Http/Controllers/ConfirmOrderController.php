<?php

namespace App\Http\Controllers;

use App\Models\ConfirmOrder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmOrderController extends Controller
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

        return view('ConfirmOrder', compact('data', 'total'));
    }

    public function upload(Request $request)
    {
        $userID = 1213123435;
        $database = app('firebase.database');
        // Validate the uploaded file
        $request->validate([
            'fileToUpload' => 'required|file|mimes:jpeg,jpg|max:2048', // Adjust max file size as needed
        ]);

        // Process the file upload
        if ($request->file('fileToUpload')->isValid()) {
            // Save the uploaded file to the storage or perform any other operations
            $request->file('fileToUpload')->store('uploads'); // Example: storing in 'uploads' directory
            $database->getReference('cart/' . $userID . '/status')->set('searching');
            $order = $database->getReference('cart/' . $userID)->getValue();
            $database->getReference('needToDeliver/')->push($order);
            $database->getReference('cart/' . $userID)->remove();
            return redirect()->route('driver');
        } else {
            // Handle invalid file upload
            return back()->withErrors(['fileToUpload' => 'Invalid file uploaded.']);
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
    public function show(ConfirmOrder $confirmOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfirmOrder $confirmOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConfirmOrder $confirmOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConfirmOrder $confirmOrder)
    {
        //
    }
}
