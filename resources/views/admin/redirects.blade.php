<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="{{asset('js/searchusers.js')}}"></script>

<x-slot name="header">
    <div class="flex justify-center">
        
        <x-nav-link class="mx-auto font-semibold text-2xl text-gray-800 leading-tight" :href="route('admin.reported.posts')" :active="request()->routeIs('admin.reported.posts')">
            {{ __('Posts denunciados') }}
        </x-nav-link>

        <x-nav-link class="mx-auto font-semibold text-2xl text-gray-800 leading-tight" :href="route('admin.reported.comments')" :active="request()->routeIs('admin.reported.comments')">
            {{ __('Comentários denunciados') }}
        </x-nav-link>


        <x-nav-link class="mx-auto font-semibold text-2xl text-gray-800 leading-tight" :href="route('admin.users')" :active="request()->routeIs('admin.users')">
            {{ __('Usuários Cadastrados') }}
        </x-nav-link>

    </div>
</x-slot>