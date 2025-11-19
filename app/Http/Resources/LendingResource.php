<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LendingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'lent_at'   => $this->lent_at,
            'due_at'    => $this->due_at,
            'return_at' => $this->return_at,

            'book' => [
                'id'     => $this->book->id,
                'title'  => $this->book->title,
                'author' => $this->book->author,
                'isbn'   => $this->book->isbn,
            ],

            'friend' => [
                'id'    => $this->friend->id,
                'name'  => $this->friend->name,
                'email' => $this->friend->email,
            ],
        ];
    }
}
