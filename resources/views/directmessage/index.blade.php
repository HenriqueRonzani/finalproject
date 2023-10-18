<link rel="stylesheet" href="{{asset('css/my.css')}}">

<x-app-layout>
    <div class="flex">
        <!-- Sidebar -->
        <div class="flex-col overflow-y-auto overflow-x-hidden">        
            <div class="flex-shrink-0"> 
                <nav style="height: calc(100vh - 4.1rem);" class=" bg-gray-100 w-80 overflow-auto">

                    @foreach ($users as $user)
                    <a href="">
                        <div class="p-4 mr-auto flex flex-1 space-x-2 border-b border-black hover:bg-gray-50">

                            @php
                                $extensions = ['png', 'jpg', 'jpeg'];
                                $file = null;

                                foreach ($extensions as $ext) {
                                    $filePath = storage_path("app/public/profilepicture/") . $user->id . ".$ext";

                                    if (file_exists($filePath)) {
                                        $file = "storage/profilepicture/" . $user->id . ".$ext";
                                        break;
                                    }
                                }
                            @endphp
                            

                                @if (isset($file))
                                    <img class="h-10 w-10 rounded-md" src=" {{ asset($file) }}">
                                @else
                                    <img class="h-10 w-10" src=" {{ asset("img/no-image.svg")}}">
                                @endif

                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div id="content">
                                        <span class="text-black">{{ $user->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach 
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-col flex-grow overflow-hidden">
            @include('directmessage.message')
        </div>
    </div>
</x-app-layout>

