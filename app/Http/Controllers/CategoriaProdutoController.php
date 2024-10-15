<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use App\Models\CategoriaProduto;
use App\Models\Loja;
use App\Services\IfoodService;
use Illuminate\Support\Facades\Auth;
use App\Models\Produto;
use App\Models\CategoriaOpcional;
use App\Models\OpcionalProduto;

class CategoriaProdutoController extends Controller
{
    //LISTAGEM
    public function index(){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Sessão do loja que está conectado
        $lojaIdConectado = session('lojaConectado')['id'];

        $categorias = CategoriaProduto::where('loja_id', $lojaIdConectado)
        ->with('loja', 'produto')
        ->orderBy('ordem')
        ->get();

        return view('categoria_produto/listar', compact('categorias'));
    }

    //RETORNAR VIEW PARA CADASTRO
    public function create(Request $request){

        $lojas = Loja::all();

        return view('categoria_produto/novo', compact('lojas'));
    }

    //CADASTRAR
    public function store(Request $request, $usuario_id){
        
        //validação dos campos
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:100',
        ]);

        //Cadastro de categoria
        $categoria = new CategoriaProduto();
        $categoria->nome = $request->input('nome');
        $categoria->descricao = $request->input('descricao');
        $categoria->ordem = $request->input('ordem');
        $categoria->loja_id = $request->input('loja_id');
        $categoria->cadastrado_usuario_id = $usuario_id;
        $categoria->save();

        return redirect()->back()->with('success', 'Cadastro feito com sucesso');

    }

    //ALTERAR VIEW
    public function edit(Request $request){
        $id = $request->input('id');
        $categoria = CategoriaProduto::find($id);
        return view('categoria_produto/novo', compact('categoria'));
    }

    //ALTERAR
    public function update(Request $request, $usuario_id, $id){
        //validação dos campos
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:100',
        ]);

         //alterando categoria
         $categoria = CategoriaProduto::find($id);
         $categoria->nome = $request->input('nome');
         $categoria->descricao = $request->input('descricao');
         $categoria->ordem = $request->input('ordem');
         $categoria->alterado_usuario_id = $usuario_id;
         $categoria->save();
 
         return redirect()->back()->with('success', 'Alteração feita com sucesso');
    }

    //EXCLUIR
    public function destroy($id){
        $produto = CategoriaProduto::find($id);
        $produto->delete();
        return redirect()->back()->with('success', 'Categoria excluida com sucesso');
    }

    public function indexJSON(Request $request){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Sessão do loja que está conectado
        $loja_id = session('lojaConectado')['id'];

        // Termo de busca, se existir
        $pesquisa = $request->input('pesquisa');

        // Busca por categorias e produtos da loja selecionada, filtrando se houver um termo de busca
        $categoria_produto = CategoriaProduto::where('loja_id', $loja_id)
        ->whereHas('produto', function($query) use ($pesquisa) {
            if ($pesquisa) {
                // Filtra produtos cujo nome contenha o termo de busca
                $query->where('nome', 'like', '%' . $pesquisa . '%');
            }
        })
        ->with(['produto' => function($query) use ($pesquisa) {
            if ($pesquisa) {
                // Filtra produtos cujo nome contenha o termo de busca
                $query->where('nome', 'like', '%' . $pesquisa . '%');
            }
        }])
        ->orderBy('ordem')
        ->get();

        return response()->json($categoria_produto);
    }

    public function importarCardapioIfood(){

        if(!session('lojaConectado')){
            return redirect('loja')->with('error', 'Selecione um loja primeiro para visualizar as categorias e produtos');
        }

        //Sessão do loja que está conectado
        $loja_id = session('lojaConectado')['id'];

        //Usuário logado
        $usuario_id = Auth::user()->id;
        
        //instancindo IfoodService
        $ifoodService = new IfoodService();

        //Obter catálogos
        $catalogs = $ifoodService->getCatalogs();

        //Catalogs
        foreach($catalogs as $catalog){
            $groups = $ifoodService->getCategories($catalog['catalogId']);
           
            //Groups
            foreach($groups as $group){
            
                //Cadastro de categoria
                $categoria = new CategoriaProduto();
                $categoria->nome = $group['name'];
                $categoria->descricao = "";
                $categoria->ordem = $group['sequence'];
                $categoria->loja_id = $loja_id;
                $categoria->cadastrado_usuario_id = $usuario_id;
                $categoria->save();

                //Items
                if(isset($group['items'])){
                    
                    foreach($group['items'] as $item){

                        //Cadastro de produto
                        $produto = new Produto();
                        $produto->nome = $item['name'];
                        $produto->descricao = isset($item['description']) ? $item['description'] : null;
                        $produto->disponibilidade = $item['status'] == 'AVAILABLE' ? true : false;
                        $produto->tempo_preparo_min_minutos = 5; //Valor padrão
                        $produto->tempo_preparo_max_minutos = 10; //Valor padrão
                        $produto->preco = $item['price']['value'];
                        $produto->categoria_produto_id = $categoria->id;
                        $produto->cadastrado_usuario_id = $usuario_id;
                        $produto->externalCodeIfood = $item['externalCode'];
                        $produto->productIdIfood = $item['productId'];
                        $produto->imagemIfood = $item['imagePath'];

                        if($item['serving'] == 'SERVES_1'){
                            $produto->quantidade_pessoa = 1;
                        }elseif($item['serving'] == 'SERVES_2'){
                            $produto->quantidade_pessoa = 2;
                        }
                        elseif($item['serving'] == 'SERVES_3'){
                            $produto->quantidade_pessoa = 3;
                        }
                        elseif($item['serving'] == 'SERVES_4'){
                            $produto->quantidade_pessoa = 4;
                        }
                        $produto->save();

                        //Se houver opcionais
                        if($item['hasOptionGroups'] == true){

                            foreach($item['optionGroups'] as $optionGroup){

                                //Cadastro de categoria de opcional de tamanhos de pizza
                                $categoria_opcional_tamanho = new CategoriaOpcional();
                                $categoria_opcional_tamanho->nome = $optionGroup['name'];
                                $categoria_opcional_tamanho->limite = $optionGroup['max'];
                                $categoria_opcional_tamanho->produto_id = $produto->id;
                                $categoria_opcional_tamanho->cadastrado_usuario_id = $usuario_id;
                                $categoria_opcional_tamanho->is_required = $optionGroup['min'] > 0 ? true : false;
                                $categoria_opcional_tamanho->save();

                                //Tamanhos de pizza
                                foreach($optionGroup['options'] as $options){

                                    //Cadastro de opcional
                                    $opcional = new OpcionalProduto();
                                    $opcional->nome = $options['name'];
                                    $opcional->categoria_opcional_id = $categoria_opcional_tamanho->id;
                                    $opcional->cadastrado_usuario_id = $usuario_id;
                                    $opcional->productIdIfood = $options['id'];
                                    $opcional->preco = $options['price']['value'];
                                    $opcional->save();
                                }
                            }
                        }

                    }

                }elseif(isset($group['pizza'])){ //Pizza

                    //Toppings
                    foreach($group['pizza']['toppings'] as $toppings){
                      
                        //Cadastro de produto
                        $produto = new Produto();
                        $produto->nome = $toppings['name'];
                        $produto->descricao = $toppings['description'];
                        $produto->disponibilidade = $toppings['status'] == 'AVAILABLE' ? true : false;
                        $produto->tempo_preparo_min_minutos = 5; //Valor padrão
                        $produto->tempo_preparo_max_minutos = 10; //Valor padrão
                        $produto->categoria_produto_id = $categoria->id;
                        $produto->cadastrado_usuario_id = $usuario_id;
                        $produto->externalCodeIfood = $toppings['externalCode'];
                        $produto->productIdIfood = $toppings['id'];
                        $produto->imagemIfood = $toppings['image'];
                        $produto->save();

                        //Se houver tamanhos de pizzas
                        if(isset($group['pizza']['sizes'])){

                            //Cadastro de categoria de opcional de tamanhos de pizza
                            $categoria_opcional_tamanho = new CategoriaOpcional();
                            $categoria_opcional_tamanho->nome = "Tamanhos";
                            $categoria_opcional_tamanho->limite = 1;
                            $categoria_opcional_tamanho->produto_id = $produto->id;
                            $categoria_opcional_tamanho->cadastrado_usuario_id = $usuario_id;
                            $categoria_opcional_tamanho->is_required = true;
                            $categoria_opcional_tamanho->save();

                            //Tamanhos de pizza
                            foreach($group['pizza']['sizes'] as $sizes){

                                //Cadastro de opcional
                                $opcional = new OpcionalProduto();
                                $opcional->nome = $sizes['name'];
                                $opcional->categoria_opcional_id = $categoria_opcional_tamanho->id;
                                $opcional->cadastrado_usuario_id = $usuario_id;
                                $opcional->externalCodeIfood = $sizes['externalCode'];
                                $opcional->productIdIfood = $sizes['id'];

                                //Preços toppings
                                foreach($toppings['prices'] as $id => $price){
                                    
                                    //Se for o mesmo ID
                                    if($sizes['id'] == $id){
                                        $opcional->preco = $price['value'];
                                    }
                                }
                                $opcional->save();
                            }
                        }

                        //Se houver massas de pizzas
                        if(isset($group['pizza']['crusts'])){

                            //Cadastro de categoria de opcional de massas de pizza
                            $categoria_opcional_tamanho = new CategoriaOpcional();
                            $categoria_opcional_tamanho->nome = "Massa";
                            $categoria_opcional_tamanho->limite = 1;
                            $categoria_opcional_tamanho->produto_id = $produto->id;
                            $categoria_opcional_tamanho->cadastrado_usuario_id = $usuario_id;
                            $categoria_opcional_tamanho->is_required = true;
                            $categoria_opcional_tamanho->save();

                            //massas de pizza
                            foreach($group['pizza']['crusts'] as $crusts){
                                
                                //Cadastro de opcional
                                $opcional = new OpcionalProduto();
                                $opcional->nome = $crusts['name'];
                                $opcional->categoria_opcional_id = $categoria_opcional_tamanho->id;
                                $opcional->cadastrado_usuario_id = $usuario_id;
                                $opcional->preco = $crusts['price']['value'];
                                $opcional->externalCodeIfood = $sizes['externalCode'];
                                $opcional->productIdIfood = $sizes['id'];
                                $opcional->save();
                            }
                        }

                        //Se houver bordas de pizzas
                        if(isset($group['pizza']['edges'])){

                            //Cadastro de categoria de opcional de bordas de pizza
                            $categoria_opcional_tamanho = new CategoriaOpcional();
                            $categoria_opcional_tamanho->nome = "Borda";
                            $categoria_opcional_tamanho->limite = 1;
                            $categoria_opcional_tamanho->produto_id = $produto->id;
                            $categoria_opcional_tamanho->cadastrado_usuario_id = $usuario_id;
                            $categoria_opcional_tamanho->is_required = true;
                            $categoria_opcional_tamanho->save();

                            //bordas de pizza
                            foreach($group['pizza']['edges'] as $edges){
                                
                                //Cadastro de opcional
                                $opcional = new OpcionalProduto();
                                $opcional->nome = $edges['name'];
                                $opcional->categoria_opcional_id = $categoria_opcional_tamanho->id;
                                $opcional->cadastrado_usuario_id = $usuario_id;
                                $opcional->preco = $edges['price']['value'];
                                $opcional->productIdIfood = $sizes['id'];
                                $opcional->save();
                            }
                        }

                    }
                }



            }
            
        }

        return redirect()->back()->with('success', 'Importado com sucesso');

    }
}