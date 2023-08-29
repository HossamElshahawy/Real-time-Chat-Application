<?php

namespace App\Http\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public function message($userId)
    {
        $authenticatedUserId = auth()->id();

        #check conversation exist

        $existingConversation = Conversation::where(function ($query) use($authenticatedUserId,$userId){
            $query->where('sender_id',$authenticatedUserId)
                ->where('receiver_id',$userId);

        })->orWhere(function ($query) use($authenticatedUserId,$userId){

            $query->where('sender_id',$userId)
                ->where('receiver_id',$authenticatedUserId);

        })->first();

        if ($existingConversation)
        {
            return redirect()->route('chat',['query'=>$existingConversation->id]);
        }

        #if not exist create new conversation

        $createdConversation = Conversation::create([
            'sender_id'=>$authenticatedUserId,
            'receiver_id'=>$userId
        ]);
        return redirect()->route('chat',['query'=>$createdConversation->id]);


    }




    public function render()
    {
        return view('livewire.users',['users'=>User::where('id','!=',auth()->id())->get()]);
    }
}
