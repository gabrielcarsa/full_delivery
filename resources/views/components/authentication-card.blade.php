<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">

    @if(!request()->is('register'))
    <div>
        <img src="{{asset("storage/images/logo-black.png")}}" width="200px" alt="Foomy"></a>
    </div>
    @endif
    
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>