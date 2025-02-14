<x-guest-layout>

    <div class="vh-100 bg-white">
        <div class="row">
            <div class="col-md-6 my-auto">

                <div class="w-75 mx-auto">
                    <img src="{{asset("storage/images/logo-black.png")}}" width="150px" alt="Foomy">

                    <p class="fw-semibold text-dark fs-6 my-3">
                        Bem vindo novamente
                    </p>

                    @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                    @endif

                    <x-validation-errors class="mb-4" />


                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="my-2">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <x-input id="email" type="email" name="email" :value="old('email')" required
                                autocomplete="username" />
                        </div>

                        <div class="my-2">
                            <x-label for="password" value="{{ __('Password') }}" />
                            <x-input id="password" type="password" name="password" required
                                autocomplete="current-password" />
                        </div>

                        <div class="block mt-4">
                            <label for="remember_me" class="flex items-center">
                                <x-checkbox id="remember_me" name="remember" />
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                            @endif

                            <x-button class="">
                                {{ __('Log in') }}
                            </x-button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="col-6">
                <img src="{{asset("storage/images/login.png")}}" class="w-100 p-3" alt="">

            </div>
        </div>
    </div>

</x-guest-layout>