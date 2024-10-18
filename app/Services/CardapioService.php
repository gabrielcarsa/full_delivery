<?php

namespace App\Services;
use App\Models\CategoriaProduto;
use App\Models\Loja;
use App\Models\Produto;
use App\Models\CategoriaOpcional;
use App\Models\OpcionalProduto;

class CardapioService
{

    //Cadastrar Categoria
    public function storeCategoria($categoriaCadastrar)
    {
        //Cadastro de categoria
        $categoria = new CategoriaProduto();
        $categoria->nome = $categoriaCadastrar['nome'];
        $categoria->descricao = $categoriaCadastrar['descricao'];
        $categoria->ordem = $categoriaCadastrar['ordem'];
        $categoria->loja_id = $categoriaCadastrar['loja_id'];
        $categoria->cadastrado_usuario_id = $categoriaCadastrar['cadastrado_usuario_id'];
        $categoria->save();

        return true;
    }

}