<?php

namespace Modules\PkgJustificatif\App\Models;

use Illuminate\Database\Eloquent\Model;

class Raison extends Model
{
    protected $fillable = [
        'code', 
        'libelle', 
        'description', 
    ];
}
