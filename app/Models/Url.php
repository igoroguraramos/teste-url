<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'url',
        'resposta',
        'status_code',
    ];

    // public function getRespostaAttribute(){
    //     return $this->attributes['resposta'];
    // }
}
