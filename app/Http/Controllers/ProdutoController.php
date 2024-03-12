<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Produto;
use App\Models\CategoriaProduto;


class ProdutoController extends Controller
{
     //LISTAGEM
     public function index(Request $request){

        $categoria_id = $request->input('categoria_id');

        $categoria = CategoriaProduto::find($categoria_id)->first();
   
        $produtos = Produto::where('categoria_id', $categoria_id)->get();

        return view('produto/listar', compact('produtos', 'categoria'));
    }

    //RETORNAR VIEW PARA CADASTRO
    public function create(Request $request){

        $categoria_id = $request->input('categoria_id');

        $categoria = CategoriaProduto::find($categoria_id)->first();

        return view('produto/novo', compact('categoria'));
    }

    //CADASTRAR
    public function store(Request $request, $categoria_id, $usuario_id){

        // Validação do formulário
        $validator = Validator::make($request->all(), [
            //TODO: fazer validações
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
            'preco' => 'required|numeric|min:0',
        ]);

        // Se a validação falhar
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //Cadastro de categoria
        $produto = new Produto();
        $produto->nome = $request->input('nome');
        $produto->descricao = $request->input('descricao');
        $produto->disponibilidade = $request->input('disponibilidade');
        $produto->preco = $request->input('preco');
        $produto->categoria_id = $categoria_id;
        $produto->cadastrado_usuario_id = $usuario_id;
        if ($request->hasFile('imagem')) {
            //Colocando nome único no arquivo
            $imagemNome = $request->file('imagem')->getClientOriginalName();
            $imagemNome = pathinfo($imagemNome, PATHINFO_FILENAME);
            $nomeArquivo = $imagemNome . '_' . time() . '.' . $request->file('imagem')->getClientOriginalExtension();

            $request->file('imagem')->storeAs('public/imagens_produtos', $nomeArquivo);
            $produto->imagem = $nomeArquivo;
        }
        $produto->save();

        return redirect()->back()->with('success', 'Cadastro feito com sucesso');

    }

    //ALTERAR VIEW

    //ALTERAR

    //EXCLUIR
    public function destroy($id){
        $produto = Produto::find($id);
        $produto->delete();
        return redirect()->back()->with('success', 'Produto excluido com sucesso');
    }
}
