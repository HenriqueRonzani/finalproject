<div id="things" class="bg-blue-200" data-route-delete="{{route('chat.delete')}}" data-route-start="{{route('message.show')}}" hidden></div>
<div class="flex flex-col bg-gray-200" style="height: calc(100vh - 4.1rem);">

    <!-- Showing messages div -->
    <div id="showmessages" class="overflow-y-auto flex-grow">
        <img class="h-full w-full" src="{{asset('img/placeholder.svg')}}">
    </div>

    <div id="profilecontainer">
        <!-- Message inputs -->
        <div id="sendmessage" class="p-3 hidden">
            <form class="flex grow w-full" onsubmit="sendmessage(event, '{{ route('message.send')}}')">
                <input id="message" type="text" placeholder="Digite sua mensagem" autocomplete="off" class="rounded-s-md w-full border p-2" required>
                <button class="bg-blue-500 text-white p-2 rounded-e-md">Enviar</button> 
            </form>
        </div>
    </div>
</div>