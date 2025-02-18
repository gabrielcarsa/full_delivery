<x-app-layout>
    <div class="container-padrao">
        <div class="bg-white shadow-md p-3 mb-3 rounded">

            <button onclick="history.back()"
                class="border rounded-circle d-flex align-items-center justify-content-center mb-3"
                style="width: 50px; height: 50px">
                <span class="material-symbols-outlined text-black m-0 p-0">
                    arrow_back
                </span>
            </button>

            <h4>
                Alterar usuário - <span class="bolder">{{$store_user->user->name}}</span>
            </h4>

            <form action="{{ route('store_users.update', ['store_user' => $store_user]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="col-12 my-3">
                    <x-label for="position" value="Cargo" />
                    <x-input type="text" name="position" id="position" value="{{$store_user->position}}" required />
                </div>
                <div class="col-12">
                    <p class="m-0 fw-semibold">
                        Nível de acesso
                    </p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level" id="ADMIN" value="ADMIN"
                            {{$store_user->access_level == "ADMIN" ? 'checked' : ''}}>
                        <label class="form-check-label fw-semibold" for="ADMIN">
                            Administrador -
                            <span class="text-secondary fw-regular">
                                Acesso total, incluindo alterações e exclusões
                            </span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level" id="MANAGER" value="MANAGER"
                            {{$store_user->access_level == "MANAGER" ? 'checked' : ''}}>
                        <label class="form-check-label fw-semibold" for="MANAGER">
                            Gerente -
                            <span class="text-secondary fw-regular">
                                Acesso total, com restrições à seções do Financeiro e da
                                Loja
                            </span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level" id="FINANCE" value="FINANCE"
                            {{$store_user->access_level == "FINANCE" ? 'checked' : ''}}>
                        <label class="form-check-label fw-semibold" for="FINANCE">
                            Financeiro -
                            <span class="text-secondary fw-regular">
                                Acesso total a seção Financeiro, com restrições à exclusões
                                do Financeiro e alterações da seção da Loja
                            </span>
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="access_level" id="USER" value="USER"
                            {{$store_user->access_level == "USER" ? 'checked' : ''}}>
                        <label class="form-check-label fw-semibold" for="USER">
                            Colaborador -
                            <span class="text-secondary fw-regular">
                                Acesso restrito as seções de Pedidos
                            </span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn bg-padrao text-white fw-bold my-3">
                    Salvar alterações
                </button>

            </form>
        </div>
    </div>
</x-app-layout>