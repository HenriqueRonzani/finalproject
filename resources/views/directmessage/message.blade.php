<div class="bg-green-200" hidden></div>
<div class="flex flex-col" style="height: calc(100vh - 4.1rem);">

    <!-- Showing messages div -->
    <div id="showmessages" class="overflow-y-auto flex-grow">
        <img class="h-full w-full" src="{{asset('img/placeholder.png')}}">
        

    </div>

    <!-- Message inputs -->
    <div class="flex p-3">
        <form id="sendmessage" class="hidden grow w-full" onsubmit="sendmessage(event, '{{ route('message.send')}}')">
            <input id="message" type="text" placeholder="Digite sua mensagem" autocomplete="off" class="rounded-s-md w-full border p-2" required>
            <button class="bg-blue-500 text-white p-2 rounded-e-md">Enviar</button> 
        </form>
    </div>
</div>