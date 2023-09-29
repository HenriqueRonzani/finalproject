<x-slot name="header">
    <div class="flex justify-center">
        

        <x-nav-link class="mx-auto font-semibold text-2xl text-gray-800 leading-tight" :href="route('atividades.posts')" :active="request()->routeIs('atividades.posts')">
            {{ __('Meus posts') }}
        </x-nav-link>

        <x-nav-link class="mx-auto font-semibold text-2xl text-gray-800 leading-tight" :href="route('atividades.likes')" :active="request()->routeIs('atividades.likes')">
            {{ __('Minhas curtidas') }}
        </x-nav-link>

        <x-nav-link class="mx-auto font-semibold text-2xl text-gray-800 leading-tight" :href="route('atividades.comments')" :active="request()->routeIs('atividades.comments')">
            {{ __('Meus comentários') }}
        </x-nav-link>


    </div>
</x-slot>