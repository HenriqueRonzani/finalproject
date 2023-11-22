<x-app-layout>


    @include('admin.redirects')

    @foreach ($reports as $report)
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">

                <div class="p-6 flex-1 space-x-2">

                    <div class="flex">

                        @if ($report->post->user->pfp != null)
                            <img class="my-auto h-10 w-10 rounded-md"
                                src=" {{ asset('storage/profilepicture/' . $report->post->user->id . '.' . $report->post->user->pfp) }}">
                        @else
                            <img class="my-auto h-10 w-10" src=" {{ asset('img/no-image.svg') }}">
                        @endif

                        <div class="flex-1 px-2">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-800">{{ $report->post->user->name }}</span>
                                    <small
                                        class="ml-2 text-sm text-gray-600">{{ $report->post->created_at->format('d/m/y, H:i') }}</small>
                                    @unless ($report->post->created_at->eq($report->post->updated_at))
                                        <small class="text-sm text-gray-600"> &middot; {{ __('editado') }}</small>
                                    @endunless
                                </div>
                            </div>

                            <p class="text-gray-800 text-2xl">{{ $report->post->title }}</p>
                        </div>
                    </div>
                    
                    <div class="flex-1">
                        @if ($report->post->type->value == 'SC')
                            <div class="max-w-5xl mx-auto">
                                <p>{!! $report->post->message !!}</p>
                            </div>
                        @else
                            <div class="max-w-5xl mx-auto">
                                <div class="code-container text-sm overflow-auto pb">
                                    <x-torchlight-code class="max-w-full" language="{{ $report->post->type->name }}">
                                        {!! $report->post->message !!}
                                    </x-torchlight-code>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="p-6 flex space-x-2">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>

                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $report->user->name }}</span>
                                <small
                                    class="ml-2 text-sm text-gray-600">{{ $report->created_at->format('d/m/y, H:i') }}</small>
                            </div>
                        </div>

                        <small class="text-sm text-gray-400">{{ __('Comentou:') }}</small>
                        
                        <div class="flex-1">

                            <div class="flex-1">
                                <p class="ml-10 mt-4 text-lg text-gray-900">{{ $report->message }}</p>

                                @unless ($report->type_id == null)
                                    <div class="max-w-5xl mx-auto">
                                        <div class="code-container text-sm overflow-auto pb">
                                            <x-torchlight-code class="max-w-full" language="{{ $report->type->name }}">
                                                {!! $report->code !!}
                                            </x-torchlight-code>
                                        </div>
                                    </div>
                                @endunless
                            </div>

                            <div class="my-5 flex max-w-fit ml-auto items-end justify-end">
                                <div class="flex-1"> 
                                    <div class="flex">

                                        <form class="m-0" method="POST" action="{{ route('report.ignore.comment', $report)}}'">
                                            @csrf
                                            <a :href="route('report.ignore.comment', $report)" onclick="event.preventDefault(); this.closest('form').submit(); alert('Denúncias Ignoradas');">
                                                <button class="bg-blue-300 w-30 p-2 rounded-md">
                                                    {{ __('Ignorar denúncias') }}
                                                </button>
                                            </a>
                                        </form>

                                        <form class="m-0" method="POST" action="{{ route('report.delete.comment', $report)}}'">
                                            @csrf
                                            @method('delete')
                                            <a :href="route('report.delete.comment', $report)" onclick="event.preventDefault(); this.closest('form').submit(); alert('Comentário Apagado');">
                                                <button class="bg-red-300 ml-5 w-30 p-2 rounded-md">
                                                    {{ __('Apagar comentário') }}
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

            </div>

        </div>

    @endforeach

</x-app-layout>
