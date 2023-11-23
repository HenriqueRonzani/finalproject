
<x-app-layout>
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('posts.update', $post) }}">
            @csrf
            @method('patch')
            <x-text-input name="title" class="block mt-1 w-full mb-2" placeholder="Digite sua dúvida, informação ou contribuição" value="{{$post->title}}" required />
            <x-input-error :messages="$errors->get('title')" class="mb-3" />

            <textarea
                rows="15"
                name="message"
                placeholder="{{ __('Digite o seu código') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $post->message) }}</textarea>

            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <div class="flex items-start justify-end">

                <select name="type_id" class="mt-4 text-sm rounded-md focus:border-blue-500 focus:ring-blue-500 h-10" required>
                <option class="uppercase" value="{{$post->type->id}}" selected>{{__($post->type->name)}}</option>

                @foreach ($category as $categories)
                    <option class="uppercase" value="{{$categories->id}}">{{$categories->name}}</option>
                @endforeach
                    </select>

                <x-primary-button class="mt-4 ml-4 h-10" >{{ __('Publicar') }}</x-primary-button>

            </div>
            <div class="flex items-start justify-end">
                <x-input-error :messages="$errors->get('type_id')" class="mt-2" />
                <div class="text-gray-800 mt-2 mr-4">
                    <a href="{{ route('dashboard',$post) }}">{{ __('Cancelar') }}</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
