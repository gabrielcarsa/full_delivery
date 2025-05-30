<x-guest-layout>

    <div class="min-vh-100 d-flex align-items-center justify-content-center">

        <div class="card m-3 p-3">


            @if($request->get('store_id') != null)
            <div class="card p-3">
                <p class="fw-semibold">
                    Olá <span class="text-padrao">{{$request->get('username')}}</span>,
                </p>
                <p class="m-0">
                    Você foi convidado para particiar do nosso sistema.
                </p>
                <p class="m-0">
                    - Termine de preencher o formulário para ter acesso ao sistema.
                </p>
            </div>
            @else
            <p class="fw-semibold text-dark fs-6 my-3">
                Seja nosso parceiro e melhore todo o funcionamento da sua loja.
            </p>
            @endif

            <x-validation-errors class="" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="my-2">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" type="text" name="name"
                        :value="old('name') ? old('name') : $request->get('username')" required autofocus />
                </div>

                <div class="my-2">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="email" name="email"
                        :value="old('email') ? old('email') : $request->get('email')" required
                        autocomplete="username" />
                </div>

                <div class="my-2">
                    <x-label for="phone" value="{{ __('Telefone') }}" />
                    <x-input id="phone" type="text" name="phone" :value="old('phone')" required />
                </div>

                <div class="my-2">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="my-2">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" />
                </div>

                <x-input type="hidden" name="store_id" :value="$request->get('store_id')" />
                <x-input type="hidden" name="position" :value="$request->get('position')" />
                <x-input type="hidden" name="access_level" :value="$request->get('access_level')" />


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

    </div>

    <script>
    // Função para aplicar a máscara de telefone
    function aplicarMascaraTelefone(inputId) {
        const input = document.getElementById(inputId);

        input.addEventListener('input', function(e) {
            let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
            let formattedValue = '';

            if (value.length > 0) {
                formattedValue = '(' + value.slice(0, 2);

                if (value.length > 2) {
                    formattedValue += ') ' + value.slice(2, 7);
                }

                if (value.length > 7) {
                    formattedValue += '-' + value.slice(7, 11);
                }
            }

            input.value = formattedValue;
        });
    }
    // Aplicar a máscara para os campos de telefone
    aplicarMascaraTelefone('phone');
    </script>
</x-guest-layout>