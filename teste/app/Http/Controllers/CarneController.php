<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carne;
use App\Models\Parcela;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class CarneController extends BaseController
{
    public function criarCarne(Request $request)
    {
        $this->validate($request, [
            'valor_total' => 'required|numeric|min:0.01',
            'qtd_parcelas' => 'required|integer|min:1',
            'data_primeiro_vencimento' => 'required|date',
            'periodicidade' => 'required|in:mensal,semanal',
            'valor_entrada' => 'nullable|numeric|min:0',
        ], [
            'valor_total.required' => 'O campo valor total é obrigatório.',
            'valor_total.numeric' => 'O campo valor total deve ser um número.',
            'valor_total.min' => 'O campo valor total deve ser pelo menos 0,01.',
            
            'qtd_parcelas.required' => 'O campo quantidade de parcelas é obrigatório.',
            'qtd_parcelas.integer' => 'O campo quantidade de parcelas deve ser um número inteiro.',
            'qtd_parcelas.min' => 'O campo quantidade de parcelas deve ser pelo menos 1.',
            
            'data_primeiro_vencimento.required' => 'O campo data do primeiro vencimento é obrigatório.',
            'data_primeiro_vencimento.date' => 'O campo data do primeiro vencimento deve ser uma data válida.',
            
            'periodicidade.required' => 'O campo periodicidade é obrigatório.',
            'periodicidade.in' => 'O campo periodicidade deve ser "mensal" ou "semanal".',
            
            'valor_entrada.numeric' => 'O campo valor de entrada deve ser um número.',
            'valor_entrada.min' => 'O campo valor de entrada deve ser pelo menos 0.',
        ]);

        $carne = Carne::create([
            'valor_total' => $request->input('valor_total'),
            'valor_entrada' => $request->input('valor_entrada', 0),
            'qtd_parcelas' => $request->input('qtd_parcelas'),
            'data_primeiro_vencimento' => $request->input('data_primeiro_vencimento'),
            'periodicidade' => $request->input('periodicidade'),
        ]);

        $valor_total = $carne->valor_total;
        $valor_entrada = $carne->valor_entrada;
        $qtd_parcelas = $carne->qtd_parcelas;
        $data_vencimento = Carbon::parse($carne->data_primeiro_vencimento);

        $parcelas = [];
        if ($valor_entrada > 0) {
            $parcelas[] = Parcela::create([
                'carne_id' => $carne->id,
                'data_vencimento' => $data_vencimento->format('Y-m-d'),
                'valor' => number_format($valor_entrada, 2, '.', ''),
                'numero' => 1,
                'entrada' => true,
            ]);

            $valor_total -= $valor_entrada;
            $qtd_parcelas -= 1;
        }

        $valor_parcela = number_format($valor_total / $qtd_parcelas, 2, '.', '');
        $soma_parcelas = $valor_parcela * $qtd_parcelas;

        // Ajuste da última parcela para compensar a diferença
        $diferenca = number_format($valor_total - $soma_parcelas, 2, '.', '');

        for ($i = 1; $i <= $qtd_parcelas; $i++) {
            if ($carne->periodicidade == 'mensal') {
                $data_vencimento->addMonth();
            } elseif ($carne->periodicidade == 'semanal') {
                $data_vencimento->addWeek();
            }

            $valor_final_parcela = $valor_parcela;

            // Ajustar a última parcela
            if ($i == $qtd_parcelas) {
                $valor_final_parcela += $diferenca;
            }

            $parcelas[] = Parcela::create([
                'carne_id' => $carne->id,
                'data_vencimento' => $data_vencimento->format('Y-m-d'),
                'valor' => number_format($valor_final_parcela, 2, '.', ''),
                'numero' => count($parcelas) + 1,
            ]);
        }

        return response()->json([
            'total' => number_format($carne->valor_total, 2, '.', ''),
            'valor_entrada' => number_format($valor_entrada, 2, '.', ''),
            'parcelas' => $parcelas,
        ]);
    }

    public function recuperarParcelas($id)
    {
        $carne = Carne::with('parcelas')->findOrFail($id);

        return response()->json([
            'parcelas' => $carne->parcelas,
        ]);
    }
}
