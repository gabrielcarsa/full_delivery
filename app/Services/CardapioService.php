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

    //Cadastrar Produto
    public function storeProduto($produtoCadastrar)
    {
        //Cadastro de produto
        $produto = new Produto();
        $produto->nome = $produtoCadastrar['nome'];
        $produto->descricao = $produtoCadastrar['descricao'];
        $produto->disponibilidade = $produtoCadastrar['disponibilidade'];
        $produto->tempo_preparo_min_minutos = $produtoCadastrar['tempo_preparo_min_minutos'];
        $produto->tempo_preparo_max_minutos = $produtoCadastrar['tempo_preparo_max_minutos'];
        $produto->preco = $produtoCadastrar['preco'];
        $produto->quantidade_pessoa = $produtoCadastrar['quantidade_pessoa'];
        $produto->categoria_produto_id = $produtoCadastrar['categoria_produto_id'];
        $produto->cadastrado_usuario_id = $produtoCadastrar['cadastrado_usuario_id'];
        $produto->imagem = $produtoCadastrar['imagem'];
        $produto->externalCodeIfood = $produtoCadastrar['externalCodeIfood'] ?? null;
        $produto->productIdIfood = $produtoCadastrar['productIdIfood'] ?? null;
        $produto->imagemIfood = $produtoCadastrar['imagemIfood'] ?? null;
        $produto->save();

        return true;

    }

}