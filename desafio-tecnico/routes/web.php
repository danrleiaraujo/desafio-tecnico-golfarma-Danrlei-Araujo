<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('orders', OrderController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
});

/*
    Criar Pedido (Create): Uma rota que permita criar um novo pedido. 
    A rota deve aceitar informações como "Cliente", "Total" e "Status" como parâmetros de entrada.
    Listar Pedidos (Read): Uma rota que liste todos os pedidos existentes. Ao acessar essa rota, a API deve retornar uma lista com as informações básicas de cada pedido.
    Detalhes do Pedido (Read): Uma rota que exiba os detalhes de um pedido específico com base no ID do pedido.
    Atualizar Pedido (Update): Uma rota que permita atualizar as informações de um pedido existente. A rota deve aceitar o ID do pedido como parâmetro de entrada e permitir a atualização de campos como "Cliente", "Total" e "Status".
    Deletar Pedido (Delete): Uma rota que permita excluir um pedido com base no ID do pedido.

*/