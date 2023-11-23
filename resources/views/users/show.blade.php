<link rel="stylesheet" href="{{ asset('css/my.css') }}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/like.js') }}"></script>
<script src="{{ asset('js/startchat.js') }}"></script>

@if(auth()->user()->userType == 3)
<script src="{{asset('js/bansuser.js')}}"></script>
@endif



<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Perfil de ') }} {!! $user->name !!}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class=" p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">
                    <div class="flex flex-col">

                        <header>
                            <h2 class="text-3xl font-medium text-gray-900">
                                {{ __('Informações do Usuário') }}
                            </h2>
                        </header>

                        <div class="mt-6 space-y-6">
                            <div>
                                <h2 class="text-2xl text-gray-950 font-bold">{{ __('Nome') }} </h2>
                                <h2 class="text-lg">{!! $user->name !!}
                                
                            </div>
                            @if($user->bannedUntil && now()->lessThan($user->bannedUntil))
                                <div class="text-lg mr-auto text-red-700 font-semibold rounded-sm w-40">
                                    <u>{{ __('Usuário Suspenso') }}</u>
                                </div>
                            @endif
                        </div>
                        
                        
                    

                        @unless ($user->is(auth()->user()))
                            <div class="mb-5 flex-grow flex items-end justify-start">
                                <button class="p-2 bg-blue-300 rounded-md text-gray-900"
                                    onclick="redirectto({{ $user->id }})">{{ __('Iniciar conversa com ' . $user->name) }}
                                </button>

                                @if(auth()->user()->userType == 3 && !($user->bannedUntil && now()->isBefore($user->bannedUntil)))
                                    <div class="ml-10 flex">
                                        <div class="flex-col items-end justify-end mr-2">                                 
                                            <label class="mt-auto" for="ban">{{__('Suspender Usuário')}}</label>
                                            <select id="ban" class="block text-sm rounded-md focus:border-blue-500 focus:ring-blue-500 h-10" required>    
                                                <option selected value="1">{{__('Um dia')}}</option>                                
                                                <option value="2">{{__('Dois dias')}}</option>
                                                <option value="7">{{__('Uma semana')}}</option>
                                                <option value="14">{{__('Duas semanas')}}</option>
                                                <option value="30">{{__('Um mês')}}</option>
                                                <option value="perma">{{__('Permanente')}}</option>
                                            </select>
                                        </div>  
                                        <div class="h-10 mt-auto">
                                            <button class="mr-auto p-2 bg-red-300 rounded-md text-gray-900"
                                            onclick="userbanning('{{$user->id}}', '{{route('admin.ban')}}' )">{{ __('Suspender') }}
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                        @endunless


                    </div>
                    {{-- my-2 py-3 --}}
                    <div class="flex-1 flex flex-col items-end justify-end">

                        <div>
                            <header class="text-center">
                                <h2 class="mx-auto text-lg font-medium text-gray-900">
                                    {{ __('Foto de Perfil') }}
                                </h2>
                            </header>
                            @if ($user->pfp != null)
                                <img class="mt-5" height="200x" width="200px"
                                    src=" {{ asset('storage/profilepicture/' . $user->id . '.' . $user->pfp) }}">

                                @if (auth()->user()->userType >= 2 && $user->userType <=1)
                                    <div class="text-center mt-1">
                                        <a href="{{ route('profile.admindelete', ['user' => $user]) }}">
                                            <button class="inline-flex items-center border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:text-gray-900 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-3">
                                                {{ __('Deletar Imagem')}}
                                            </button>
                                        </a>
                                    </div>
                                @endif

                            @else
                                <img class="my-5" height="200px" width="200px"
                                    src=" {{ asset('img/no-image.svg') }}">
                            @endif
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">

            <div class="p-6 flex space-x-2">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Posts do Usuário') }}
                    </h2>
                </header>
            </div>



            @forelse ($user->posts as $post)
                <div class="p-6 flex-1 space-x-2">


                    <div class="flex">

                        @if ($post->user->pfp != null)
                            <img class="my-auto h-10 w-10 rounded-md"
                                src=" {{ asset('storage/profilepicture/' . $post->user->id . '.' . $post->user->pfp) }}">
                        @else
                            <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                        @endif

                        <div class="flex-1 px-2">
                            <div class="flex justify-between items-center">
                                <div>
                                    <a href="{{ route('user.show', ['user' => $post->user]) }}">
                                        <span
                                            class="text-gray-500 hover:text-gray-950 hover:border-b-2">{{ $post->user->name }}</span>
                                    </a>

                                    <small
                                        class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('d/m/y, H:i') }}</small>
                                    @unless ($post->created_at->eq($post->updated_at))
                                        <small class="text-sm text-gray-600"> &middot; {{ __('editado') }}</small>
                                    @endunless
                                </div>

                                @if ($post->user->is(auth()->user()) || auth()->user()->userType >= 2)
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            @if ($post->user->is(auth()->user()))
                                                <x-dropdown-link :href="route('posts.edit', $post)">
                                                    {{ __('Editar') }}
                                                </x-dropdown-link>
                                            @endif
                                            
                                                <form class="m-0" method="POST" action="{{ route('posts.destroy', $post) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('posts.destroy', $post)"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Apagar') }}
                                                    </x-dropdown-link>
                                                </form>
                                        </x-slot>

                                    </x-dropdown>
                                @else
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <form class="m-0" method="POST" action="{{ route('report.post', $post->id)}}">
                                                @csrf
                                                <x-dropdown-link :href="route('report.post', $post->id)"
                                                onclick="event.preventDefault(); this.closest('form').submit(); alert('Post Denunciado')">
                                                {{ __('Denunciar') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                @endif
                            </div>
                            <p class="text-gray-800 text-2xl">{{ $post->title }}</p>
                        </div>
                    </div>
                    <div class="flex-1">

                        

                        @if ($post->type->value == 'SC')
                            <p>{!! $post->message !!}</p>
                        @else
                            <div class="max-w-5xl mx-auto" >
                                <div class="code-container text-sm overflow-auto pb">
                                    <x-torchlight-code class="max-w-full" language="{{ $post->type->name }}">
                                        {!! $post->message !!}
                                    </x-torchlight-code>
                                </div>
                            </div>
                        @endif


                        <div class="flex justify-start mt-5">


                            <form data-likable="{{ 'post' }}" class="flex justify-start likeform"
                                onsubmit="toggle(event, '{{ route('like.toggle', $post) }}', '{{route('like.remove', $post)}}')">

                                @if ($post->hasLiked($post))
                                    <input type=hidden name="liked" value="true">


                                    <button type="submit">
                                        <img class="likeimage mx-2 w-7" src="{{ asset('img/liked.svg') }}">
                                    </button>
                                @else
                                    <input id="liked" type=hidden name="liked" value="false">

                                    <button type="submit">
                                        <img class="likeimage mx-2 w-7" src="{{ asset('img/not-liked.svg') }}">
                                    </button>
                                @endif

                                <p class="likecounter"> {!! count($post->likes) !!} </p>
                            </form>

                            <a href="{{ route('comments.index', ['post' => $post]) }}">
                                <img class="mx-2 w-7" src="{{ asset('img/comment.svg') }}">

                            </a>

                            <p> {!! count($post->comment) !!} </p>

                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 flex space-x-2">
                    <h2 class="align center mx-auto text-gray-500"> {{ __($user->name . ' não possui posts') }}
                </div>
            @endforelse
        </div>
    </div>

</x-app-layout>
