<link rel="stylesheet" href="{{ asset('css/my.css') }}">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/like.js') }}"></script>
<script src="{{ asset('js/hascodecheck.js') }}"></script>

<meta name="csrf-token" content="{{ csrf_token() }}">

<x-app-layout>

    <x-slot name="header">
        <div class="flex ">
            <a class="flex" id="back" href="{{ session('previous-comment-back') }}">
                <svg class="h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <!--! Font Awesome Pro 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M205 34.8c11.5 5.1 19 16.6 19 29.2v64H336c97.2 0 176 78.8 176 176c0 113.3-81.5 163.9-100.2 174.1c-2.5 1.4-5.3 1.9-8.1 1.9c-10.9 0-19.7-8.9-19.7-19.7c0-7.5 4.3-14.4 9.8-19.5c9.4-8.8 22.2-26.4 22.2-56.7c0-53-43-96-96-96H224v64c0 12.6-7.4 24.1-19 29.2s-25 3-34.4-5.4l-160-144C3.9 225.7 0 217.1 0 208s3.9-17.7 10.6-23.8l160-144c9.4-8.5 22.9-10.6 34.4-5.4z"/>
                </svg>
            </a>
            <h2 class="justify-center text-center max-w-fit mx-auto font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Comentários') }}
            </h2>
        </div>
    </x-slot>


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
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
                        <div class="max-w-5xl mx-auto">
                            <p>{!! $post->message !!}</p>
                        </div>
                    @else
                        <div class="max-w-5xl mx-auto">
                            <div class="code-container text-sm overflow-auto pb">
                                <x-torchlight-code class="max-w-full" language="{{ $post->type->name }}">
                                    {!! $post->message !!}
                                </x-torchlight-code>
                            </div>
                        </div>
                    @endif
                        

                    <div class="flex justify-start">


                        <form data-likable="{{ 'post' }}" class="flex justify-start likeform"
                            onsubmit="toggle(event, '{{ route('like.toggle', $post) }}')">

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

                    </div>

                </div>

            </div>


            <form class="max-w-6xl mx-auto" method="POST"
                action="{{ route('comments.store', ['post' => $post->id]) }}">
                
                @csrf
                <p class="py-4 text-gray-800 text-3xl text-center">
                    {{ __('Adicionar Comentário') }}
                </p>

                <textarea rows="5" name="message" placeholder="{{ __('Digite seu comentário') }}"
                    class=" mx-auto block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">{{ old('message') }}</textarea>

                    <x-input-error :messages="$errors->get('message')" class="mt-2" />
                <div class="mx-auto my-5 block w-3/4">
                    <input id="hascode" name="hascode" value="false" type="checkbox">

                    <label for="hascode" class="text-lg">
                        {{ __('Adicionar código ao comentário?') }}
                    </label>
                </div>

                <div id="codecomment" hidden>

                    <textarea rows="15" name="code" placeholder="{{ __('Digite o seu código') }}"
                        class="mx-auto block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        spellcheck="false">{{ old('code') }}</textarea>

                    <x-input-error :messages="$errors->get('code')" class="mt-2" />

                    @if ($post->type->value == 'SC')
                        <div class="flex w-5/6 items-start justify-end">
                            <select name="type_id"
                                class=" mt-4 text-sm rounded-md focus:border-blue-500 focus:ring-blue-500 h-10">

                                @foreach ($category as $categories)
                                    @if ($categories->value == 'SC')
                                        <option selected class="uppercase" value="{{ $categories->id }}">
                                            {{ $categories->name }}</option>
                                    @else
                                        <option class="uppercase" value="{{ $categories->id }}">
                                            {{ $categories->name }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                    @endif

                    <x-input-error :messages="$errors->get('type')" class="mt-2" />

                </div>

                <div class="flex justify-center">
                    <x-primary-button class=" mx-auto my-4 h-10">{{ __('Publicar') }}</x-primary-button>
                </div>
            </form>

            {{-- Most Liked Comment --}}
            @unless ($mostliked == null)
                <div class="bg-white shadow-sm rounded-lg divide-y">

                    <div class="p-10 flex-1 space-x-2">
                        <header>
                            <h2 class="text-lg text-center justify-center font-medium text-gray-900">
                                {{ __('Comentário mais Curtido') }}
                            </h2>

                        </header>

                        <div id="mostlikedvalue" data-most-liked="{{ $mostliked->id }}" hidden></div>

                        <div class="flex">

                            @if ($mostliked->user->pfp != null)
                                <img class="my-auto h-10 w-10 rounded-md"
                                    src=" {{ asset('storage/profilepicture/' . $mostliked->user->id . '.' . $mostliked->user->pfp) }}">
                            @else
                                <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                            @endif

                            <div class="flex-1 px-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <a href="{{ route('user.show', ['user' => $mostliked->user]) }}">
                                            <span
                                                class="text-gray-500 hover:text-gray-950 hover:border-b-2">{{ $mostliked->user->name }}</span>
                                        </a>
                                        <small
                                            class="ml-2 text-sm text-gray-600">{{ $mostliked->created_at->format('d/m/y, H:i') }}</small>
                                    </div>


                                    @if ($mostliked->user->is(auth()->user()))
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
                                                <x-dropdown-link :href="route('comments.edit', $mostliked, $post->id)">
                                                    {{ __('Editar') }}
                                                </x-dropdown-link>

                                                <form class="m-0" method="POST"
                                                    action="{{ route('comments.destroy', $mostliked) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('comments.destroy', $mostliked)"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Deletar') }}
                                                    </x-dropdown-link>
                                                </form>

                                            </x-slot>

                                        </x-dropdown>
                                    @endif
                                </div>
                                <small class="text-sm text-gray-400">{{ __('Comentou:') }}</small>
                            </div>
                        </div>

                        <div class="flex-1">
                            <p class="ml-10 mt-4 text-lg text-gray-900">{{ $mostliked->message }}</p>

                            @unless ($mostliked->type_id == null)
                                <div class="max-w-5xl mx-auto">
                                    <div class="code-container text-sm overflow-auto pb">
                                        <x-torchlight-code class="max-w-full" language="{{ $mostliked->type->name }}">
                                            {!! $mostliked->code !!}
                                        </x-torchlight-code>
                                    </div>
                                </div>
                            @endunless
                        </div>

                        <div class="flex justify-start mt-5">
                            <form id="mostlikedform" 
                                data-likable="{{ 'comment' }}"
                                class="flex justify-start likeform"
                                onsubmit="toggle(event, '{{ route('like.toggle', $mostliked) }}', this)">

                                @if ($mostliked->hasLiked($mostliked))
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

                                <p class="likecounter"> {!! count($mostliked->likes) !!} </p>
                            </form>
                        </div>
                    </div>
                </div>
            @endunless
        </div>
    </div>
        @foreach ($comments as $comment)
            <div class="max-w-6xl mx-auto mt-4">
                <div class="bg-white shadow-sm rounded-lg divide-y">

                    @if ($comment->id == $mostliked->id)
                        <div id="mostliked">
                    @endif

                    <div class="p-6 flex-1 space-x-2">

                        <div class="flex">

                            @if ($comment->user->pfp != null)
                                <img class="my-auto h-10 w-10 rounded-md"
                                    src=" {{ asset('storage/profilepicture/' . $comment->user->id . '.' . $comment->user->pfp) }}">
                            @else
                                <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                            @endif

                            <div class="flex-1 px-2">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <a href="{{ route('user.show', ['user' => $comment->user]) }}">
                                            <span
                                                class="text-gray-500 hover:text-gray-950 hover:border-b-2">{{ $comment->user->name }}</span>
                                        </a>
                                        <small
                                            class="ml-2 text-sm text-gray-600">{{ $comment->created_at->format('d/m/y, H:i') }}</small>
                                    </div>


                                    @if ($comment->user->is(auth()->user()) || auth()->user()->userType >= 2)
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path
                                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('comments.edit', $comment, $post->id)">
                                                    {{ __('Editar') }}
                                                </x-dropdown-link>

                                                <form class="m-0" method="POST"
                                                    action="{{ route('comments.destroy', $comment) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('comments.destroy', $comment)"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Deletar') }}
                                                    </x-dropdown-link>
                                                </form>

                                            </x-slot>

                                        </x-dropdown>
                                    @else
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path
                                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <form class="m-0" method="POST"
                                                    action="{{ route('report.comment', $comment->id) }}">
                                                    @csrf
                                                    <x-dropdown-link :href="route('report.comment', $comment->id)"
                                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Denunciar') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    @endif
                                </div>
                                <small class="text-sm text-gray-400">{{ __('Comentou:') }}</small>
                            </div>
                        </div>

                        <div class="flex-1">
                            <p class="ml-10 mt-4 text-lg text-gray-900">{{ $comment->message }}</p>

                            @unless ($comment->type_id == null)
                                <div class="max-w-5xl mx-auto">
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
                                onsubmit="toggle(event, '{{ route('like.toggle', $comment) }}', this)">

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

                        @if ($comment->id == $mostliked->id)
                                    </div>
                        @endif
                    </div>
                </div>
            </div>
    @endforeach
</x-app-layout>
