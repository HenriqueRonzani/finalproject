<link rel="stylesheet" href="{{ asset('css/my.css') }}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/like.js') }}"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>

    @include('atividades.redirects')

            @foreach ($postsandcomments as $postorcomment)

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">

                @if ($postorcomment instanceof \App\Models\Post)
                    <div class="p-6 flex-1 space-x-2">

                        <div class="flex">

                            @if ($postorcomment->user->pfp != null)
                                <img class="my-auto h-10 w-10 rounded-md"
                                    src=" {{ asset('storage/profilepicture/' . $postorcomment->user->id . '.' . $postorcomment->user->pfp) }}">
                            @else
                                <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                            @endif

                            <div class="flex-1 px-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <a href="{{ route('user.show', ['user' => $postorcomment->user]) }}">
                                            <span
                                                class="text-gray-500 hover:text-gray-950 hover:border-b-2">{{ $postorcomment->user->name }}</span>
                                        </a>
                                        <small
                                            class="ml-2 text-sm text-gray-600">{{ $postorcomment->created_at->format('d/m/y, H:i') }}</small>
                                        @unless ($postorcomment->created_at->eq($postorcomment->updated_at))
                                            <small class="text-sm text-gray-600"> &middot; {{ __('editado') }}</small>
                                        @endunless
                                    </div>

                                    @if ($postorcomment->user->is(auth()->user()) || auth()->user()->userType >= 2)
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
                                                @if ($postorcomment->user->is(auth()->user()))
                                                    <x-dropdown-link :href="route('posts.edit', $postorcomment)">
                                                        {{ __('Editar') }}
                                                    </x-dropdown-link>
                                                @endif
                                                
                                                    <form class="m-0" method="POST" action="{{ route('posts.destroy', $postorcomment) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <x-dropdown-link :href="route('posts.destroy', $postorcomment)"
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
                                                <form class="m-0" method="POST" action="{{ route('report.post', $postorcomment->id)}}">
                                                    @csrf
                                                    <x-dropdown-link :href="route('report.post', $postorcomment->id)"
                                                    onclick="event.preventDefault(); this.closest('form').submit(); alert('Post Denunciado')">
                                                    {{ __('Denunciar') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    @endif

                                </div>

                                <p class="text-gray-800 text-2xl">{{ $postorcomment->title }}</p>
                            </div>
                        </div>
                        <div class="flex-1">
                            @if ($postorcomment->type->value == 'SC')
                                <div class="max-w-5xl mx-auto">
                                    <p>{!! $postorcomment->message !!}</p>
                                </div>
                            @else
                                <div class="max-w-5xl mx-auto">
                                    <div class="code-container text-sm overflow-auto pb">
                                        <x-torchlight-code class="max-w-full"
                                            language="{{ $postorcomment->type->name }}">
                                            {!! $postorcomment->message !!}
                                        </x-torchlight-code>
                                    </div>
                                </div>
                            @endif


                            <div class="flex justify-start mt-5">


                                <form data-likable="{{ 'post' }}" class="flex justify-start likeform"
                                    onsubmit="toggle(event, '{{ route('like.toggle', $postorcomment) }}' ,'{{ route('like.remove', $postorcomment) }}')">

                                    @if ($postorcomment->hasLiked($postorcomment))
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

                                    <p class="likecounter"> {!! count($postorcomment->likes) !!} </p>
                                </form>



                                <a href="{{ route('comments.index', ['post' => $postorcomment]) }}">
                                    <img class="mx-2 w-7" src="{{ asset('img/comment.svg') }}">

                                </a>

                                <p> {!! count($postorcomment->comment) !!} </p>

                            </div>
                        </div>
                    </div>
                @else
                
                    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">

                        <div class="p-6 flex-1 space-x-2">

                            <div class="flex">

                                @if ($postorcomment->post->user->pfp != null)
                                    <img class="my-auto h-10 w-10 rounded-md"
                                        src=" {{ asset('storage/profilepicture/' . $postorcomment->post->user->id . '.' . $postorcomment->post->user->pfp) }}">
                                @else
                                    <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                                @endif

                                <div class="flex-1 px-2">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-800">{{ $postorcomment->post->user->name }}</span>
                                            <small
                                                class="ml-2 text-sm text-gray-600">{{ $postorcomment->post->created_at->format('d/m/y, H:i') }}</small>
                                            @unless ($postorcomment->post->created_at->eq($postorcomment->post->updated_at))
                                                <small class="text-sm text-gray-600"> &middot; {{ __('editado') }}</small>
                                            @endunless
                                        </div>

                                        @if ($postorcomment->post->user->is(auth()->user()) || auth()->user()->userType >= 2)
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
                                                    @if ($postorcomment->post->user->is(auth()->user()))
                                                        <x-dropdown-link :href="route('posts.edit', $postorcomment->post)">
                                                            {{ __('Editar') }}
                                                        </x-dropdown-link>
                                                    @endif
                                                    
                                                        <form class="m-0" method="POST" action="{{ route('posts.destroy', $postorcomment->post) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <x-dropdown-link :href="route('posts.destroy', $postorcomment->post)"
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
                                                    <form class="m-0" method="POST" action="{{ route('report.post', $postorcomment->post->id)}}">
                                                        @csrf
                                                        <x-dropdown-link :href="route('report.post', $postorcomment->post->id)"
                                                        onclick="event.preventDefault(); this.closest('form').submit(); alert('Post Denunciado')">
                                                        {{ __('Denunciar') }}
                                                        </x-dropdown-link>
                                                    </form>
                                                </x-slot>
                                            </x-dropdown>
                                        @endif

                                    </div>

                                    <p class="text-gray-800 text-2xl">{{ $postorcomment->post->title }}</p>
                                </div>
                            </div>
                            <div class="flex-1">
                                @if ($postorcomment->post->type->value == 'SC')
                                    <div class="max-w-5xl mx-auto">
                                        <p>{!! $postorcomment->post->message !!}</p>
                                    </div>
                                @else
                                    <div class="max-w-5xl mx-auto">
                                        <div class="code-container text-sm overflow-auto pb">
                                            <x-torchlight-code class="max-w-full"
                                                language="{{ $postorcomment->post->type->name }}">
                                                {!! $postorcomment->post->message !!}
                                            </x-torchlight-code>
                                        </div>
                                    </div>
                                @endif


                                <div class="flex justify-start mt-5">


                                    <form data-likable="{{ 'post' }}"
                                        class="flex justify-start likeform"
                                        onsubmit="toggle(event, '{{ route('like.toggle', $postorcomment->post) }}', '{{ route('like.remove', $postorcomment->post) }}')">

                                        @if ($postorcomment->post->hasLiked($postorcomment->post))
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

                                        <p class="likecounter"> {!! count($postorcomment->post->likes) !!} </p>
                                    </form>



                                    <a href="{{ route('comments.index', ['post' => $postorcomment->post]) }}">
                                        <img class="mx-2 w-7" src="{{ asset('img/comment.svg') }}">

                                    </a>

                                    <p> {!! count($postorcomment->post->comment) !!} </p>

                                </div>
                            </div>
                        </div>

                        
                            <div class="p-6 flex space-x-2">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>

                                <div class="flex-1">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-800">{{ $postorcomment->user->name }}</span>
                                            <small
                                                class="ml-2 text-sm text-gray-600">{{ $postorcomment->created_at->format('d/m/y, H:i') }}</small>
                                        </div>


                                        @if ($postorcomment->user->is(auth()->user()) || auth()->user()->userType >= 2)
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
                                                @if ($postorcomment->user->is(auth()->user()))
                                                    <x-dropdown-link :href="route('posts.edit', $postorcomment)">
                                                        {{ __('Editar') }}
                                                    </x-dropdown-link>
                                                @endif
                                                
                                                    <form class="m-0" method="POST" action="{{ route('posts.destroy', $postorcomment) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <x-dropdown-link :href="route('posts.destroy', $postorcomment)"
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
                                                <form class="m-0" method="POST" action="{{ route('report.post', $postorcomment->id)}}">
                                                    @csrf
                                                    <x-dropdown-link :href="route('report.post', $postorcomment->id)"
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
                                        <p class="ml-10 mt-4 text-lg text-gray-900">{{ $postorcomment->message }}</p>
                                
                                        @unless ($postorcomment->type_id == null)
                                                <div class="max-w-5xl mx-auto" >
                                                    <div class="code-container text-sm overflow-auto pb">
                                                        <x-torchlight-code class="max-w-full" language="{{ $postorcomment->type->name }}">
                                                            {!! $postorcomment->code !!}
                                                        </x-torchlight-code>
                                                    </div>
                                                </div>
                                        @endunless
                                    </div>
                                    <div class="flex justify-start mt-5">
                    
                                        <form data-likable="{{ 'comment' }}" class="flex justify-start likeform"
                                            onsubmit="toggle(event, '{{ route('like.toggle', $postorcomment) }}','{{ route('like.remove', $postorcomment) }}')">
                    
                                            @if ($postorcomment->hasLiked($postorcomment))
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
                    
                                            <p class="likecounter"> {!! count($postorcomment->likes) !!} </p>
                                        </form>
                                    </div>
                                </div>
                                
                            </div>
                           
                        
                    </div>
                    
                @endif

                </div>
            </div>

            @endforeach
        </div>
    </div>


</x-app-layout>
