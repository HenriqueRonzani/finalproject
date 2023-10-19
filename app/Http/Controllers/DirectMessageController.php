<?php

namespace App\Http\Controllers;

use App\Models\DirectMessage;
use App\Models\User;
use Illuminate\Http\Request;

class DirectMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return View('directmessage.index',[
            'users' => User::where('id', '!=', auth()->user()->id)->get()
        ]);
    }

    public function show(Request $request)
    {
        $selecteduser = $request->input('selecteduser');
        $user = auth()->user()->id;

        $messages = DirectMessage::with(['sender', 'receiver'])
        ->where(function ($query) use ($user, $selecteduser) {
            $query->where('SENDER_ID', $user)
                ->where('RECEIVER_ID', $selecteduser);
        })
        ->orWhere(function ($query) use ($user, $selecteduser) {
            $query->where('SENDER_ID', $selecteduser)
                ->where('RECEIVER_ID', $user);
        })
        ->orderBy('CREATED_AT')
        ->get();
        
        $authuserimage = $this->getimage(auth()->user()->id);
        $otheruserimage = $this->getimage($selecteduser);

        
        $data = [
            'userimage' => $authuserimage,
            'otheruserimage' => $otheruserimage,
            'messages' => $messages,
            'user' => $user,
        ];

        return response()->json($data);
    }

    public function getimage($id){
        $extensions = ['png', 'jpg', 'jpeg'];
        $file = asset("img/no-image.svg");

        foreach ($extensions as $ext) {
            $filePath = storage_path("app/public/profilepicture/") . $id . ".$ext";

            if (file_exists($filePath)) {
                $file = "storage/profilepicture/" . $id . ".$ext";
                break;
            }
        }
        return $file;
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
