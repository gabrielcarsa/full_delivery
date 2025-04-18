<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produto;
use App\Models\CategoriaProduto;
use App\Models\Loja;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
     //LISTAGEM
     public function index(Request $request){

        //Exibir produtos de uma categoria
        $categoria_produto_id = $request->get('categoria_produto_id');

        $categoria = CategoriaProduto::find($categoria_produto_id);
        
        $produtos = Produto::where('categoria_produto_id', $categoria_produto_id)->get();

        $loja = Loja::where('id', $categoria->loja_id)->first();

        $data = [
            'produtos' => $produtos,
            'categoria' => $categoria,
            'loja' => $loja,
        ];
      
        return view('produto/listar', compact('data'));
    }

    //RETORNAR VIEW PARA CADASTRO
    public function create(Request $request){

        $categoria_produto_id = $request->input('categoria_produto_id');

        $categoria = CategoriaProduto::find($categoria_produto_id);

        return view('produto/novo', compact('categoria'));
    }

    //CADASTRAR
    public function store(Request $request, $categoria_produto_id, $usuario_id){

        $request->merge([
            'preco' => str_replace(['.', ','], ['', '.'], $request->input('preco')),
        ]);

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'imagem' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,heic',
                'max:20480',
                function ($attribute, $value, $fail) {
                    // Verifique se é uma imagem válida
                    $imageInfo = getimagesize($value->getPathname());
                    if ($imageInfo === false) {
                        $fail('O arquivo fornecido não é uma imagem válida.');
                        return;
                    }
                    
                    // Obtém as dimensões da imagem
                    list($width, $height) = $imageInfo;
            
                     // Verifique se a imagem tem pelo menos 300x275 de resolução
                    if ($width < 300 || $height < 275) {
                        $fail('A imagem deve ter no mínimo 300x275 pixels de resolução.');
                    }
                },
            ],
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'preco' => 'required|numeric',
            'quantidade_pessoa' => 'required|numeric|min:1',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $categoria = CategoriaProduto::where('id', $categoria_produto_id)->first();
        $loja = Loja::where('id', $categoria->loja_id)->first();

        //Se houver imagem
        if ($request->hasFile('imagem')) {
            //Colocando nome único no arquivo
            $imagemNome = $request->file('imagem')->getClientOriginalName();
            $imagemNome = pathinfo($imagemNome, PATHINFO_FILENAME);
            $nomeArquivo = $imagemNome . '_' . time() . '.' . $request->file('imagem')->getClientOriginalExtension();

            $request->file('imagem')->storeAs('public/'.$loja->nome.'/imagens_produtos', $nomeArquivo);
        }

        Produto::create([
            'nome' => $request->input('nome'),
            'descricao' => $request->input('descricao'),
            'disponibilidade' => $request->input('disponibilidade'),
            'tempo_preparo_min_minutos' => $request->input('tempo_preparo_min_minutos'),
            'tempo_preparo_max_minutos' => $request->input('tempo_preparo_max_minutos'),
            'preco' => $request->input('preco'),
            'quantidade_pessoa' => $request->input('quantidade_pessoa'),
            'categoria_produto_id' => $categoria_produto_id,
            'cadastrado_usuario_id' => $usuario_id,
            'imagem' => $nomeArquivo,
        ]);

        return redirect()->back()->with('success', 'Cadastro feito com sucesso');

    }

    //ALTERAR VIEW
    public function edit(Request $request){
        $id = $request->input('id');
        $produto = Produto::find($id);
        return view('produto/novo', compact('produto'));
    }


    //ALTERAR
    public function update(Request $request, $usuario_id, $id){
        
        $request->merge([
            'preco' => str_replace(['.', ','], ['', '.'], $request->input('preco')),
        ]);

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'preco' => 'required|numeric',
            'quantidade_pessoa' => 'required|numeric|min:1',
        ]);

        //Alterando produto
        $produto = Produto::find($id);
        $produto->nome = $request->input('nome');
        $produto->descricao = $request->input('descricao');
        $produto->disponibilidade = $request->input('disponibilidade');
        $produto->tempo_preparo_min_minutos = $request->input('tempo_preparo_min_minutos');
        $produto->tempo_preparo_max_minutos = $request->input('tempo_preparo_max_minutos');
        $produto->preco = $request->input('preco'); // Converter a string diretamente para um número em ponto flutuante

        $produto->quantidade_pessoa = $request->input('quantidade_pessoa');
        $produto->alterado_usuario_id = $usuario_id;
        $produto->save();
        return redirect()->back()->with('success', 'Alteração feita com sucesso');
    }

    //EXCLUIR
    public function destroy($id){
        $produto = Produto::find($id);
         // Excluir a imagem do armazenamento, se existir
        if ($produto->imagem) {
            $categoria = CategoriaProduto::where('id', $produto->categoria_produto_id)->first();
            $loja = Loja::where('id', $categoria->loja_id)->first();
            Storage::delete('public/'. $loja->nome .'/imagens_produtos/' . $produto->imagem);
        }
        $produto->delete();
        return redirect()->back()->with('success', 'Produto excluido com sucesso');
    }


    //ALTERAR VIEW DESCONTO
    public function edit_promocao(Request $request){
        $id = $request->input('id');
        $produto = Produto::find($id);
        return view('produto/promocao', compact('produto'));
    }

    //PROMOÇÃO
    public function update_promocao(Request $request, $id){
        
        $request->merge([
            'preco_promocao' => str_replace(['.', ','], ['', '.'], $request->input('preco_promocao')),
        ]);

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'preco_promocao' => 'required|numeric',
        ]);

        //Alterando produto
        $produto = Produto::find($id);

        $produto->preco_promocao = (double) $request->input('preco_promocao'); // Converter a string diretamente para um número em ponto flutuante
        $produto->save();
        return redirect()->back()->with('success', 'Promoção cadastrada');
    }

    //DESTACAR  
    public function destacar(Request $request){
        $id = $request->input('id');

        //Alterando produto
        $produto = Produto::find($id);

        if($produto->destacar == null || $produto->destacar == false){
            $produto->destacar = true; 
        }else{
            $produto->destacar = false; 
        }
        $produto->save();
        return redirect()->back()->with('success', 'Produto em destaque');
    }
}