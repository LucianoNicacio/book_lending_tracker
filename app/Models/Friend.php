<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    public function lendings () {
        return $this->hasMany(Lending::class);
    }
}
