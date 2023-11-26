<link rel="stylesheet" href="{{asset('css/my.css')}}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/messageuser.js')}}"></script>
<script src="{{ asset('js/sendmessage.js')}}"></script>
<script src="{{ asset('js/newconversation.js')}}"></script>
<script src="{{ asset('js/messagefromredirect.js')}}"></script>
<script src="{{ asset('js/deletechat.js')}}"></script>


<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="flex-col flex-shrink-0 overflow-y-auto overflow-x-hidden">        
            <div class="flex-shrink-0">     

                @if (!$hasAllConversations)
                    <div cursor id="addConversation" class="bg-blue-500 w-full text-center py-5 border border-black text-white text-xl hover:bg-blue-600 hover:text-gray-200 cursor-pointer" onclick="newconversation('{{ route('message.new') }}')">+ Conversa</div>
                    <nav id="showusers" style="height: calc(100vh - 8.4rem);" class=" bg-gray-100 w-80 overflow-auto">
                @else   
                    <nav id="showusers" style="height: calc(100vh - 4.1rem);" class=" bg-gray-100 w-80 overflow-auto">
                @endif

                    @foreach ($users as $user)
                        <div data-user-id="{{$user->id}}" class="group user p-4 mr-auto flex flex-1 space-x-2 border-b border-black hover:bg-gray-200" onclick="message(this, '{{ route('message.show') }}')">

                            @if ($user->pfp != null)
                                <img class="my-auto h-10 w-10 rounded-md" src=" {{asset("storage/profilepicture/". $user->id. "." . $user->pfp) }}">
                            @else
                                <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                            @endif

                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div id="content">
                                        <span class="text-black">{{ $user->name }}</span>
                                    </div>
                                    <button class="hidden group-hover:inline-block transition" onclick="deleteconversation('{{$user->id}}','{{ route('chat.delete')}}', event, this)">
                                        <svg class="h-4 w-4 text-gray-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M32 32H480c17.7 0 32 14.3 32 32V96c0 17.7-14.3 32-32 32H32C14.3 128 0 113.7 0 96V64C0 46.3 14.3 32 32 32zm0 128H480V416c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V160zm128 80c0 8.8 7.2 16 16 16H336c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach 
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-col flex-grow overflow-hidden">
            @include('directmessage.message')
        </div>
    </div>
</x-app-layout>

