
<x-app-layout>

    <x-slot name="header">
        <div class="space-x-10 ">
            <h2 class=" text-center font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Editar Comentário') }}
            </h2>
        </div>
    </x-slot>


    <div class="mt-6 max-w-6xl bg-white rounded-md mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('comments.update', ['comment' => $comment->id]) }}">

            @csrf
            @method('patch')
            
            <label for="message">
                <h2 class="max-w-fit mx-auto text-3xl font-medium mb-2">
                    {{__('Comentário')}}
                </h2>
            </label>
            
            <textarea
            rows="5"
            name="message"
            id="message"
            placeholder="{{ __('Digite seu comentário') }}"
            class="mt-2 mx-auto block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message', $comment->message) }}</textarea>

            <x-input-error :messages="$errors->get('message')" class="mt-2" />


            @unless ($comment->type_id == null)

                <label for="code">
                    <h2 class="max-w-fit mx-auto text-3xl font-medium mt-10">
                        {{__('Código do comentário')}}
                    </h2>
                </label>
                
                <textarea rows="15" name="code" id="code" placeholder="{{ __('Digite o seu código') }}"
                class="mt-2 mx-auto block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                spellcheck="false">{{ old('code', $comment->code) }}</textarea>
            
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            @endunless
            <div class="flex justify-center">
                <x-primary-button class=" mx-auto my-4 h-10" >{{ __('Publicar') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>