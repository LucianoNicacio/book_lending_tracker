<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'friend_id', 'lent_at', 'return_at', 'due_at'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function friend()
    {
        return $this->belongsTo(Friend::class);
    }
}
