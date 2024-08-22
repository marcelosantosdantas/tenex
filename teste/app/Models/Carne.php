<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carne extends Model
{
    protected $table = 'carnes';

    protected $fillable = [
        'valor_total', 'valor_entrada', 'qtd_parcelas', 'data_primeiro_vencimento', 'periodicidade'
    ];
    

    public function parcelas()
    {
        return $this->hasMany(Parcela::class);
    }
}
