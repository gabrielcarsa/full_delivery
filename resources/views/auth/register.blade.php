<x-guest-layout>

    <div class="vh-100 bg-white d-flex align-items-center justify-content-center">
        <div class="row">
            <div class="col-md-6">

                <img src="{{asset("storage/images/logo-black.png")}}" width="150px" alt="Foomy">

                <p class="fw-semibold text-dark fs-6 my-3">
                    Seja nosso parceiro e melhore todo o funcionamento da sua loja.
                </p>

                <x-validation-errors class="" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="my-2">
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" type="text" name="name" :value="old('name')"
                            required autofocus/>
                    </div>

                    <div class="my-2">
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" type="email" name="email" :value="old('email')"
                            required autocomplete="username" />
                    </div>

                    <div class="my-2">
                        <x-label for="password" value="{{ __('Password') }}" />
                        <x-input id="password" type="password" name="password" required
                            autocomplete="new-password" />
                    </div>

                    <div class="my-2">
                        <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="password_confirmation" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                    </div>

                    @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-label for="terms">
                            <div class="flex items-center">
                                <x-checkbox name="terms" id="terms" required />

                                <div class="ms-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'"
                                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms
                                        of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'"
                                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy
                                        Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-label>
                    </div>
                    @endif

                    <div class="">
                        <x-button class="my-3">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>

            </div>
            <div class="col-6 d-flex align-items-center">
                <img src="{{asset("storage/images/login-seguro.svg")}}" width="500px" alt="">

            </div>
        </div>
    </div>

</x-guest-layout>