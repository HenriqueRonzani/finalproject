<link rel="stylesheet" href="{{ asset('css/my.css') }}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/like.js')}}"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">


<x-app-layout>
    
    @include('atividades.redirects')

    @foreach ($posts as $post)
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
           
                <div class="p-6 flex-1 space-x-2">
                    
                    <div class="flex">

                    @if ($post->user->pfp != null)
                        <img class="my-auto h-10 w-10 rounded-md" src=" {{asset("storage/profilepicture/". $post->user->id. "." . $post->user->pfp) }}">
                    @else
                        <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                    @endif

                    <div class="flex-1 px-2">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $post->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('d/m/y, H:i') }}</small>
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
                            <div class="max-w-5xl mx-auto" >
                                <p>{!! $post->message !!}</p>
                            </div>
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
                            onsubmit="toggle(event, '{{ route('like.toggle', $post )}}')" >

                                @if ($post->hasLiked($post))

                                    <input type=hidden name="liked" value="true">
                                    
                                    <button class="likebutton" type="submit">
                                        <img class="likeimage mx-2 w-7" src="{{ asset('img/liked.svg') }}">
                                    </button>

                                @else

                                    <input id="liked" type=hidden name="liked" value="false">

                                    <button class="likebutton" type="submit">
                                        <img class="likeimage mx-2 w-7" src="{{ asset('img/not-liked.svg') }}">
                                    </button>

                                @endif

                                <p class="likecounter"> {!! count($post->likes) !!} </p>
                            </form>

                            

                            <a href="{{ route('comments.index', ['post' => $post])}}">
                                <img class="mx-2 w-7" src="{{ asset('img/comment.svg')}}">
                            
                            </a>

                            <p> {!! count($post->comment) !!} </p>

                        </div>
                    </div>
                </div>

                @foreach($post->comment as $comment)
                    @if ($comment->user->is(auth()->user()))
                        <div class="p-6 flex space-x-2">
            
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
            
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-800">{{ $comment->user->name }}</span>
                                        <small class="ml-2 text-sm text-gray-600">{{ $comment->created_at->format('d/m/y, H:i') }}</small>
                                    </div>
            
            
                                    @if ($comment->user->is(auth()->user()) || auth()->user()->userType >= 2)
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
                                                @if ($comment->user->is(auth()->user()))
                                                    <x-dropdown-link :href="route('posts.edit', $comment)">
                                                        {{ __('Editar') }}
                                                    </x-dropdown-link>
                                                @endif
                                                
                                                    <form class="m-0" method="POST" action="{{ route('posts.destroy', $comment) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <x-dropdown-link :href="route('posts.destroy', $comment)"
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
                                                <form class="m-0" method="POST" action="{{ route('report.post', $comment->id)}}">
                                                    @csrf
                                                    <x-dropdown-link :href="route('report.post', $comment->id)"
                                                    onclick="event.preventDefault(); this.closest('form').submit(); alert('Post Denunciado')">
                                                    {{ __('Denunciar') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    @endif
                                    
                                    
                                
                            </div>
                            <small class="text-sm text-gray-400">{{__('Comentou:')}}</small>
                            <div class="flex-1">
                                <p class="ml-10 mt-4 text-lg text-gray-900">{{ $comment->message }}</p>
                        
                                @unless ($comment->type_id == null)
                                        <div class="max-w-5xl mx-auto" >
                                            <div class="code-container text-sm overflow-auto pb">
                                                <x-torchlight-code class="max-w-full" language="{{ $comment->type->name }}">
                                                    {!! $comment->code !!}
                                                </x-torchlight-code>
                                            </div>
                                        </div>
                                @endunless
                            </div>
                            <div class="flex justify-start mt-5">
        
                                <form data-likable="{{ 'comment' }}" class="flex justify-start likeform"
                                    onsubmit="toggle(event, '{{ route('like.toggle', $comment) }}')">
        
                                    @if ($comment->hasLiked($comment))
                                        <input type=hidden name="liked" value="true">
        
                                        <button class="likebutton" type="submit">
                                            <img class="likeimage mx-2 w-7" src="{{ asset('img/liked.svg') }}">
                                        </button>
                                    @else
                                        <input id="liked" type=hidden name="liked" value="false">
        
                                        <button class="likebutton" type="submit">
                                            <img class="likeimage mx-2 w-7" src="{{ asset('img/not-liked.svg') }}">
                                        </button>
                                    @endif
        
                                    <p class="likecounter"> {!! count($comment->likes) !!} </p>
                                </form>
                            </div>
                        </div>
                    </div>  
                @endif
            @endforeach
        </div>
    </div>
    @endforeach

</x-app-layout> 