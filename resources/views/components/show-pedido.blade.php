<div>
    <h5>{{ $pedido->cliente->nome }}</h5>
    <p>{{ $pedido->entrega->rua }}, {{ $pedido->entrega->bairro }}, {{ $pedido->entrega->numero }}</p>
   
    <!-- Exibir itens do pedido -->
    @foreach ($pedido->item_pedido as $item)
    <p>Produto: {{ $item->produto->nome }}</p>
    <p>Quantidade: {{ $item->quantidade }}</p>
    <p>Preço Unitário: {{ $item->preco_unitario }}</p>
    <p>Subtotal: {{ $item->subtotal }}</p>
    @endforeach

</div>