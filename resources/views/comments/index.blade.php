<link rel="stylesheet" href="{{ asset('css/my.css') }}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/like.js')}}"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>

    <x-slot name="header">
        <div class="flex space-x-10">
            <a href="{{ url()->previous() }}">
                <img class="h-6" src="{{ asset('img/arrow.svg') }}">
            </a>
            <h2 class=" text-center font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Comentários') }}
            </h2>
        </div>
    </x-slot>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <div class="p-6 flex space-x-2">
                @php
                    $extensions = ['png', 'jpg', 'jpeg'];
                    $file = null;

                    foreach ($extensions as $ext) {
                        $filePath = storage_path("app/public/profilepicture/") . $post->user->id . ".$ext";

                        if (file_exists($filePath)) {
                            $file = "storage/profilepicture/" . $post->user->id . ".$ext";
                            break;
                        }
                    }
                @endphp
            

                @if (isset($file))
                    <img class="h-10 w-10 rounded-md" src=" {{ asset($file) }}">
                @else
                    <img class="h-10 w-10" src=" {{ asset("img/no-image.svg")}}">
                @endif

                <div class="flex-1">

                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $post->user->name }}</span>
                            <small
                                class="ml-2 text-sm text-gray-600">{{ $post->created_at->format('d/m/y, H:i') }}</small>
                            @unless ($post->created_at->eq($post->updated_at))
                                <small class="text-sm text-gray-600"> &middot; {{ __('editado') }}</small>
                            @endunless
                        </div>

                        @if ($post->user->is(auth()->user()))
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
                                    <x-dropdown-link :href="route('posts.edit', $post)">
                                        {{ __('Editar') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                        @csrf
                                        @method('delete')
                                        <x-dropdown-link :href="route('posts.destroy', $post)"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Deletar') }}
                                        </x-dropdown-link>
                                    </form>

                                </x-slot>

                            </x-dropdown>
                        @endif

                    </div>

                    <p class="text-gray-800 text-2xl">{{ $post->title }}</p>

                    @if ($post->type->value == 'SC')
                        <p class="my-6">{!! $post->message !!}</p>
                    @else
                        <pre class=" text-sm overflow-auto max-w-5xl">
                            <x-torchlight-code language="{{ $post->type->name }}">
                                {!! $post->message !!}
                            </x-torchlight-code>
                        </pre>
                    @endif


                    <div class="flex justify-start">


                        <form data-post-id="{{ $post->id }}" class="flex justify-start likeform" onsubmit="toggle(event, '{{ route('like.toggle', $post )}}')" >

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

                    </div>

                </div>

            </div>


            <form method="POST" action="{{ route('comments.store', ['post' => $post->id]) }}">

                @csrf
                <p class="py-4 text-gray-800 text-3xl text-center">
                    {{ __('Adicionar Comentário') }}
                </p>

                <textarea rows="5" name="message" placeholder="{{ __('Digite seu comentário') }}"
                    class=" mx-auto block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('message') }}</textarea>

                <x-input-error :messages="$errors->get('message')" class="mt-2" />

                <div class="flex justify-center">
                    <x-primary-button class=" mx-auto my-4 h-10">{{ __('Publicar') }}</x-primary-button>
                </div>
            </form>

        </div>
    </div>


    @foreach ($comments as $comment)
        <div class="max-w-7xl mx-auto pb-4 sm:px-6 lg:px-8">
            <div class=" bg-white shadow-sm rounded-lg divide-y">
                <div class="p-6 flex space-x-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>

                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $comment->user->name }}</span>
                                <small
                                    class="ml-2 text-sm text-gray-600">{{ $comment->created_at->format('d/m/y, H:i') }}</small>
                            </div>


                            @if ($comment->user->is(auth()->user()))
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
                                        <x-dropdown-link :href="route('comments.edit', $comment, $post->id)">
                                            {{ __('Editar') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('comments.destroy', $comment) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('comments.destroy', $comment)"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Deletar') }}
                                            </x-dropdown-link>
                                        </form>

                                    </x-slot>

                                </x-dropdown>
                            @endif
                        </div>

                        <p class="mt-4 text-lg text-gray-900">{{ $comment->message }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
