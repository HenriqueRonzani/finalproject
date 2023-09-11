<link rel="stylesheet" href="{{ asset('css/my.css') }}">

<x-app-layout>

    <x-slot name="header">
        <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Comentários') }}
        </h2>
    </x-slot>


    <div class="max-w-6xl mx-auto p-3 sm:px-6 lg:px-8">
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <div class="p-6 flex space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>

                <div class="flex-1">

                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $posts->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $posts->created_at->format('d/m/y, H:i') }}</small>
                            @unless ($posts->created_at->eq($posts->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                            @endunless
                        </div>

                        @if ($posts->user->is(auth()->user()))
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('posts.edit', $posts)">
                                    {{ __('Edit') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('posts.destroy', $posts) }}">
                                    @csrf
                                    @method('delete')
                                    <x-dropdown-link :href="route('posts.destroy', $posts)" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </form>
                                
                            </x-slot>
                            
                        </x-dropdown>
                        
                        @endif
                        
                    </div>

                    <p class="text-gray-800 text-2xl">{{ $posts->title }}</p>

                    {{--
                    <pre class="min-w-0 text-sm overflow-auto max-w-5xl">
                        <x-torchlight-code language="{{$posts->type->name}}">
                            {!! $posts->message !!}
                        </x-torchlight-code>
                    </pre>
                    --}}

                    <p> {!! $posts->message !!} </p>

                    <div class="flex justify-start">


                        <form method="get" class="flex justify-start" action= "{{ route('like.toggle', ['post' => $posts])}}">

                            @if ($posts->hasLiked($posts))

                            <button type="submit">
                                <img class="mx-2 w-7" src="{{ asset('img/liked.png') }}">
                            </button>

                            @else

                            <button type="submit">
                                <img class="mx-2 w-7" src="{{ asset('img/not-liked.png') }}">
                            </button>

                            @endif

                        </form>
                    </div>


                </div>

            </div>


                <form method="POST" action="{{ route('comments.store', ['post' => $posts->id]) }}">

                    @csrf
                    <p class="py-4 text-gray-800 text-3xl text-center">
                        {{ __('Adicionar Comentário')}}
                    </p>

                    <textarea
                    rows="5"
                    name="message"
                    placeholder="{{ __('Digite seu comentário') }}"
                    class=" mx-auto block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    >{{ old('message') }}</textarea>

                    <x-input-error :messages="$errors->get('message')" class="mt-2" />

                <div class="flex justify-center">
                <x-primary-button class=" mx-auto my-4 h-10" >{{ __('Publicar') }}</x-primary-button>
                </div>


        </div>
    </div>


    @foreach ($posts->comment as $comments)

    <div class="max-w-6xl mx-auto pb-4 sm:px-6 lg:px-8" >
        <div class=" bg-white shadow-sm rounded-lg divide-y">
            <div class="p-6 flex space-x-2">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>

                <div class="flex-1">

                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-gray-800">{{ $comments->user->name }}</span>
                            <small class="ml-2 text-sm text-gray-600">{{ $comments->created_at->format('d/m/y, H:i') }}</small>

                        </div>
                    </div>
                    <p class="mt-4 text-lg text-gray-900">{{ $comments->message }}</p>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</x-app-layout>
