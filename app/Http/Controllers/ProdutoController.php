<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produto;
use App\Models\CategoriaProduto;
use App\Models\Restaurante;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
     //LISTAGEM
     public function index(Request $request){

        //Exibir produtos de uma categoria
        $categoria_id = $request->get('categoria_id');

        $categoria = CategoriaProduto::find($categoria_id);

        $produtos = Produto::where('categoria_id', $categoria_id)->get();

        $restaurante = Restaurante::where('id', $categoria->restaurante_id)->first();

        $data = [
            'produtos' => $produtos,
            'categoria' => $categoria,
            'restaurante' => $restaurante,
        ];
      
        return view('produto/listar', compact('data'));
    }

    //RETORNAR VIEW PARA CADASTRO
    public function create(Request $request){

        $categoria_id = $request->input('categoria_id');

        $categoria = CategoriaProduto::find($categoria_id);

        return view('produto/novo', compact('categoria'));
    }

    //CADASTRAR
    public function store(Request $request, $categoria_id, $usuario_id){

        $request->merge([
            'preco' => str_replace(['.', ','], ['', '.'], $request->input('preco')),
        ]);

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'imagem' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg',
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
            
                    // Verifique se é quadrada
                    if ($width !== $height) {
                        $fail('A imagem deve ser quadrada.');
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

        $categoria = CategoriaProduto::where('id', $categoria_id)->first();
        $restaurante = Restaurante::where('id', $categoria->restaurante_id)->first();

        //Cadastro de produto
        $produto = new Produto();
        $produto->nome = $request->input('nome');
        $produto->descricao = $request->input('descricao');
        $produto->disponibilidade = $request->input('disponibilidade');

        $produto->preco = (double) $request->input('preco'); // Converter a string diretamente para um número em ponto flutuante

        $produto->quantidade_pessoa = $request->input('quantidade_pessoa');
        $produto->categoria_id = $categoria_id;
        $produto->cadastrado_usuario_id = $usuario_id;
        if ($request->hasFile('imagem')) {
            //Colocando nome único no arquivo
            $imagemNome = $request->file('imagem')->getClientOriginalName();
            $imagemNome = pathinfo($imagemNome, PATHINFO_FILENAME);
            $nomeArquivo = $imagemNome . '_' . time() . '.' . $request->file('imagem')->getClientOriginalExtension();

            $request->file('imagem')->storeAs('public/'.$restaurante->nome.'/imagens_produtos', $nomeArquivo);
            $produto->imagem = $nomeArquivo;
        }
        $produto->save();

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

        $produto->preco = (double) $request->input('preco'); // Converter a string diretamente para um número em ponto flutuante

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
            Storage::delete('public/imagens_produtos/' . $produto->imagem);
        }
        $produto->delete();
        return redirect()->back()->with('success', 'Produto excluido com sucesso');
    }
}