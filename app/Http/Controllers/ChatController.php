<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('chat');
    }

    public function sendMessage(Request $request)
    {
        $database = app('firebase.database');
        $conversationId = $request->input('conversation_id');
        $message = $request->input('message');
        $currentUserId = 1213123435;

        $messageRef = $database->getReference('messages/' . $conversationId)->push();
        $messageRef->set([
            'sender' => $currentUserId,
            'message' => $message,
            'timestamp' => time()
        ]);

        return redirect()->back();
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
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
