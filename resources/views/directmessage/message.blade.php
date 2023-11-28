<div id="things" class="bg-blue-200" data-route-delete="{{route('chat.delete')}}" data-route-start="{{route('message.show')}}" hidden></div>
<div class="flex flex-col bg-gray-200" style="height: calc(100vh - 4.1rem);">

    <!-- Showing messages div -->
    <div id="panel" class="hidden bg-slate-50 h-14">
        <img id="panel-user-image" class="h-10 my-auto mx-5">        
        <div class="my-auto">
            <a id="panel-redirect">
                <span id="panel-user-name" class="text-gray-900 hover:text-gray-700 hover:border-b-2"></span>
            </a>
        </div>
    </div>

    <div id="showmessages" class="overflow-y-auto flex-grow">
        <img class="h-full w-full" src="{{asset('img/placeholder.svg')}}">
    </div>

    <div id="profilecontainer">
        <!-- Message inputs -->
        <div id="sendmessage" class="p-3 hidden">
            <form class="flex grow w-full" onsubmit="sendmessage(event, '{{ route('message.send')}}')">
                <input id="message" type="text" placeholder="Digite sua mensagem" autocomplete="off" class="rounded-s-md w-full border p-2" required>
                <button class="flex bg-blue-500 text-white p-2 rounded-e-md">
                    <svg class="w-5 h-5 my-auto mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                        <!--! Font Awesome Pro 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z"/>
                    </svg>
                    {{ __('Enviar')}}
                    
                </button> 
            </form>
        </div>
    </div>
</div>