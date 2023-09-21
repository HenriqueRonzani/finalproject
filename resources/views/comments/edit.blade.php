
<x-app-layout>
    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('comments.update', ['comment' => $comment->id]) }}">

            @csrf
            @method('patch')
            <p class="py-4 text-gray-800 text-3xl text-center">
                {{ __('Adicionar Comentário')}}
            </p>

            <textarea
            rows="5"
            name="message"
            placeholder="{{ __('Digite seu comentário') }}"
            class=" mx-auto block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $comment->message) }}</textarea>

            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <div class="flex justify-center">
                <x-primary-button class=" mx-auto my-4 h-10" >{{ __('Publicar') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>