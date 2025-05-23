<?php

namespace Modules\PkgEntretienInscrition\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidate extends Model
{
    protected $fillable = ['name'];

    public function participations(): HasMany
    {
        return $this->hasMany(Participation::class);
    }
}
