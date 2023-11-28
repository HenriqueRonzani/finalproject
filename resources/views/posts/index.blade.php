<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{ asset('js/changecodetype.js') }}"></script>
<x-app-layout>
        <x-slot name="header">
            <h2 class="text-center font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Criar Posts') }}
            </h2>
        </x-slot>
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <x-text-input name="title" class="block mt-1 w-full mb-5" placeholder="Digite sua dúvida, informação ou contribuição" required />
            <x-input-error :messages="$errors->get('title')" class="mb-3" />

                <label class="text-2xl text-gray-800 font-semibold" for="code">
                    {{((__('Código ou dúvida')))}}
                </label>
                
            <textarea
                id="code"
                rows="15"
                name="message"
                placeholder="{{ __('Digite o seu código ou dúvida') }}"
                class="block w-full bg-gray-200 text-gray-800 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                spellcheck="false"
                required
                >{{ old('message') }}</textarea>

            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <div class="flex items-start justify-end">

                <select id="types" name="type_id" class="mt-4 text-sm rounded-md focus:border-blue-500 focus:ring-blue-500 h-10" required>

                @foreach ($category as $categories)
             
                @if ($categories->value == 'SC')
                    <option selected class="uppercase" value="{{$categories->id}}">{{$categories->name}}</option>
                @else
                    <option class="uppercase" value="{{$categories->id}}">{{$categories->name}}</option>
                @endif

                @endforeach
                    </select>

                <x-primary-button class="mt-4 ml-4 h-10" >{{ __('Publicar') }}</x-primary-button>

            </div>

            <div class="flex items-start justify-end">
                <x-input-error :messages="$errors->get('type_id')" class="mt-2" />
            </div>
        </form>
    </div>
</x-app-layout>
