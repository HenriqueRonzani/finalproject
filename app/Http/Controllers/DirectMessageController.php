<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
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
        $user = User::find(auth()->user()->id);
        $users = $user->getConversationUsers();
        $hasAllConversations = $user->conversations()->count() == (User::all()->count() -1 );

        return View('directmessage.index',[
            'users' => $users,
            'hasAllConversations' => $hasAllConversations,
        ]);
    }

    public function sendmessage(Request $request)
    {   
        $message = $request->input("message");
        $receiverid = $request->input("receiver");
        $userid = auth()->user()->id;


        $data = [
            'message' => $message,
            'sender_id' => $userid,
            'receiver_id' => $receiverid,
        ];


        DirectMessage::create($data);
        
        

        $user = User::find($userid);
        $receiveruser = User::find($receiverid);

        //

        $conversations = $user->getconversationsbetweenusers($user->id, $receiverid);

        $createdconversation = false;
        if($conversations->count() === 0) {
            $data = [  
                'user1_id' => $user->id,
                'user2_id' => $receiverid
            ];
            Conversation::create($data);
            $createdconversation = true;
        }

        //



        $userimage = $user->pfp ? "storage/profilepicture/" . $user->id . '.' . $user->pfp : 'img/no-image.svg';

        $responsedata = [
            'receiveruser' => $receiveruser,
            'userimage' => $userimage,
            'currentdate' => date("H:i d/m"),
            'createdconversation' => $createdconversation,
        ];
        return response()->json($responsedata);
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
        

        
        $data = [
            'messages' => $messages,
            'user' => User::find($user),
            'otheruser' => User::find($selecteduser)
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

    public function newconversation() {
        
        $thisuser = User::find(auth()->user()->id);

        $users = $thisuser->getotherUsers();
        
        $data = [
            "users"=> $users
        ];
        return response()->json($data);
    }


    public function deleteconversation(Request $request) {
        
        $otheruserid = $request->input('otheruserid');
        $user = User::find(auth()->user()->id);
        $conversation = $user->getconversationsbetweenusers($user->id, $otheruserid)->first();

        $conversation->delete();

        return response()->json();
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
        // INSERT INTO `directmessage` (`id`, `message`, `sender_id`, `receiver_id`, `created_at`, `updated_at`) VALUES
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
