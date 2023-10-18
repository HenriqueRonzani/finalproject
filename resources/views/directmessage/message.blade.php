<div class="flex flex-col h-screen">
    <div class="overflow-y-auto flex-grow">
        
        @php
            use App\Models\DirectMessage;

            $messages = DirectMessage::with(['sender', 'receiver'])
            ->where(function ($query) {
                $query->where('SENDER_ID', 1)
                    ->where('RECEIVER_ID', 2);
            })
            ->orWhere(function ($query) {
                $query->where('SENDER_ID', 2)
                    ->where('RECEIVER_ID', 1);
            })
            ->orderBy('CREATED_AT')
            ->get();
        @endphp

        @foreach ($messages as $message)
            @if ($message->sender_id == auth()->user()->id)
                <p class="justify-end">{{ __('Ele que mandou') }}{{$message->message}}</p>
            @else
                
                <p>{{ __('Outra pessoa mandou') }}{{$message->message}}</p>
            @endif
        @endforeach 
    </div>

    <!-- Input Box for New Message -->
    <div class="p-4">
        <!-- Your input form goes here -->
        <input type="text" placeholder="Type your message..." class="w-full border p-2">
        <button class="bg-blue-500 text-white p-2">Send</button>
    </div>
</div>