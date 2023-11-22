<link rel="stylesheet" href="{{ asset('css/my.css') }}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/like.js') }}"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($posts as $post)
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
                            <p class="text-gray-800 text-xl">{{ $post->title }}</p>
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

                            <form data-post-id="{{ $post->id }}" class="flex justify-start likeform"
                                onsubmit="toggle(event, '{{ route('like.toggle', $post) }}')">

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
            @endforeach
        </div>
    </div>

</x-app-layout>
