<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{asset('js/searchusers.js')}}"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Área Administrativa') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class=" p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <header>
                    <h2 class="text-2xl mb-5 pb-5 text-center font-medium text-gray-900">
                        {{ __('Lista de Usuários') }}
                    </h2>
                </header>

                <div class="max-w-5xl pb-10 mb-5 border-b border-gray-200 mx-auto items-center justify-center">
                    <x-input-label for="name" class="text-center" :value="__('Pesquisar por nome de usuário')" />
                    <x-text-input data-search-route="{{route('search.search')}}" id="name" class="block mt-1 w-full" type="text" name="name"/>
                </div>
                
                <div id="users" class="mt-5">
                    @foreach ($users as $user)
                        <a href="{{route('user.show',$user->id)}}">
                            <div data-user-id="{{$user->id}}" class="user p-4 mr-auto flex flex-1 space-x-2 border-b border-black hover:bg-gray-50">
                                @if ($user->pfp != null)
                                    <img class="my-auto h-10 w-10 rounded-md" src="{{asset("storage/profilepicture/". $user->id. "." . $user->pfp) }}">
                                @else
                                    <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                                @endif

                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <div id="content">
                                            <span class="text-black">{{ $user->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>