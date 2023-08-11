<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('Digite o seu código') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />
            <x-primary-button class="mt-4">{{ __('Publicar') }}</x-primary-button>

            <select name="type" required>
            <option selected>{{'Selecione uma linguagem'}}</option>

            @foreach ($category as $categories)
                <option value="{{$categories->id}}">{{$categories->name}}</option>
            @endforeach
                </select>

        </form>
    </div>
</x-app-layout>
