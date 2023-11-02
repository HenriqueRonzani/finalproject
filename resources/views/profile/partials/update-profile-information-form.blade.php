<section>
    <header class="mb-2">
        <h2 class="text-2xl font-medium text-gray-900">
            {{ __('Informações do Perfil') }}
        </h2>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="py-5 border-y-2">
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Foto de Perfil') }}
            </h2>
    
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Envie uma imagem em .jpg, .jpeg ou .png para alterar a foto de perfil") }}
            </p>
        </header>


        @if ($user->pfp != null)
                <img class="mt-5" height="200x" width="200px" src=" {{ asset("storage/profilepicture/$user->id.$user->pfp") }}">
               
                <a href="{{ route('profile.picdelete') }}">
                    <button class="inline-flex items-center border border-transparent rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:text-gray-900 active:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-3">
                        {{ __('Deletar Imagem')}}
                    </button>
                </a>
        @else
                <img class="my-5" height="200px" width="200px" src=" {{ asset("img/no-image.svg")}}">
        @endif
       
        

        <form method="post" enctype="multipart/form-data" action="{{ route('profile.picture') }}" class="mt-3 space-y-6">
            @csrf
            <label for="arquivo">Enviar imagem</label>

            <input class="block " type="file" name="picture" id="picture" accept=".png,.jpg,.jpeg" required>

            <x-primary-button>{{ __('Enviar') }}</x-primary-button>
        </form>

    </div>

    <form method="post" action="{{ route('profile.update') }}" class="mt-2 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Salvo.') }}</p>
            @endif
        </div>
    </form>
</section>
