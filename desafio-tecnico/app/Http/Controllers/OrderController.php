<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller{
    /**
     * Lista os pedidos existentes no banco de dados, dividindo em 15 páginas por vez.
     */
    public function index()
    {
        return response()->json(Order::paginate(15));
    }

    /**
     * Novo pedido no banco de dados.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente' => 'required|string|max:255',
            'total'   => 'required|numeric|min:0',
            'status'  => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order = Order::create($data);
        return response()->json($order, 201);
    }

    /**
     * Mostra um pedido feito através de seu id.
     */
    public function show(Order $order)
    {
        return response()->json($order);
    }

    /**
     * Atualiza um pedido existente no banco de dados.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'cliente' => 'sometimes|required|string|max:255',
            'total'   => 'sometimes|required|numeric|min:0',
            'status'  => 'sometimes|required|in:pending,processing,completed,cancelled',
        ]);
        $order->update($data);
        return response()->json($order);
    }

    /**
     * Exclui um pedido no banco de dados.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
