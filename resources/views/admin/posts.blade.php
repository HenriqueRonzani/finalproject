<x-app-layout>

    
    @include('admin.redirects')

    
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="mt-6 p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <header>
                    <h2 class="text-2xl mb-5 pb-5 border-gray-200 mx-auto border-b text-center font-medium text-gray-900">
                        {{ __('Posts Denunciados') }}
                    </h2>
                </header>

                <div id="users" class="mt-5 divide-y">

                    @foreach ($reports as $report)
                        <div class="p-6 flex-1 space-x-2 ">
                            
                            <div class="flex">
                                @if ($report->user->pfp != null)
                                    <img class="my-auto h-10 w-10 rounded-md"
                                        src=" {{ asset('storage/profilepicture/' . $report->user->id . '.' . $report->user->pfp) }}">
                                @else
                                    <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                                @endif

                                <div class="flex-1 px-2">
                                    <div class="flex justify-between items-center">
                                        <div>

                                            <a href="{{ route('user.show', ['user' => $report->user]) }}">
                                                <span
                                                    class="text-gray-500 hover:text-gray-950 hover:border-b-2">{{ $report->user->name }}</span>
                                            </a>

                                            <small
                                                class="ml-2 text-sm text-gray-600">{{ $report->created_at->format('d/m/y, H:i') }}</small>
                                            @unless ($report->created_at->eq($report->updated_at))
                                                <small class="text-sm text-gray-600"> &middot; {{ __('editado') }}</small>
                                            @endunless
                                        </div>

                                    </div>
                                    <p class="text-gray-800 text-xl">{{ $report->title }}</p>
                                </div>
                            </div>
                            
                            <div class="flex-1">

                                @if ($report->type->value == 'SC')
                                    <div class="max-w-5xl mx-auto">
                                        <p>{!! $report->message !!}</p>
                                    </div>
                                @else
                                    <div class="max-w-5xl mx-auto">
                                        <div class="code-container text-sm overflow-auto pb">
                                            <x-torchlight-code class="max-w-full" language="{{ $report->type->name }}">
                                                {!! $report->message !!}
                                            </x-torchlight-code>
                                        </div>
                                    </div>
                                @endif

                                <div class="flex justify-between max-w-5xl mx-auto">
                                    <div class="flex justify-start mt-5">
                                        <a href="{{ route('comments.index', ['post' => $report]) }}">
                                            <img class="mr-2 w-7" src="{{ asset('img/comment.svg') }}">
                                        </a>
                                        <p> {!! count($report->comment) !!} </p>
                                    </div>

                                    <div class="ml-2 my-5 flex items-center">
                                        <div class="flex-1"> 
                                            <div class="flex">

                                                <form class="m-0" method="POST" action="{{ route('report.ignore.post', $report)}}'">
                                                    @csrf
                                                    <a :href="route('report.ignore.post', $report)" onclick="event.preventDefault(); this.closest('form').submit(); alert('Denúncias Ignoradas');">
                                                        <button class="bg-blue-300 w-30 p-2 rounded-md">
                                                            {{ __('Ignorar denúncias') }}
                                                        </button>
                                                    </a>
                                                </form>

                                                <form class="m-0" method="POST" action="{{ route('report.delete.post', $report)}}'">
                                                    @csrf
                                                    @method('delete')
                                                    <a :href="route('report.delete.post', $report)" onclick="event.preventDefault(); this.closest('form').submit(); alert('Post Apagado');">
                                                        <button class="bg-red-300 ml-5 w-30 p-2 rounded-md">
                                                            {{ __('Apagar post') }}
                                                        </button>
                                                    </a>
                                                </form>

                                            </div>
                                            <div class="ml-auto max-w-fit">
                                                <small>
                                                    {{ 'Número de denúncias: ' . $report->report_count}}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

</x-app-layout>
