<x-app-layout>

    <div class="container-padrao">

        <div class="bg-white shadow-md p-3 mb-3 rounded">

            <!-- Card Header  -->
            <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
                <h2 class="m-0 fw-semibold fs-5">
                    {{empty($category) ? 'Cadastro de Categoria' : 'Alterar ' . $category->name }}</h2>
            </div>

            <!-- Card Body -->
            <div class="card-body">

                <form class="row g-3"
                    action="{{empty($category) ? route('product_categories.store') : route('product_categories.store', ['product_category' => $category->id] ) }}"
                    method="post" autocomplete="off">
                    @csrf
                    @if(!empty($category))
                    @method('PUT')
                    @endif

                    <div class="col-md-6">
                        <x-label for="name" value="Nome da categoria" />
                        <x-input type="text" name="name" value="{{!empty($category) ? $category->name : old('name')}}"
                            id="name" required />
                    </div>
                    <div class="col-md-6">
                        <x-label for="description" value="Descrição" />
                        <x-input type="text" name="description"
                            value="{{!empty($category) ? $category->description : old('description')}}" id="description"
                            required />
                    </div>
                    <div class="col-md-6">
                        <x-label for="order" value="Ordem de exibição no cardápio" />
                        <x-input type="number" name="order"
                            value="{{!empty($category) ? $category->order : old('order')}}" id="order" required />
                    </div>
                    @if(empty($category))
                    <div class="col-md-6">
                        <label for="inputLoja" class="">Loja</label>
                        <select required id="inputLoja" name="store_id" class="form-select form-control">
                            <option value="" {{ old('store_id') == null ? 'selected' : '' }}>-- Selecione --</option>
                            @foreach ($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                {{$store->nome}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <x-button class="">
                        Salvar
                    </x-button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>