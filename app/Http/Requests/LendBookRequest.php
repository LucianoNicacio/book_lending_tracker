<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LendBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_id' => ['required', 'exists:books,id'],
            'friend_id' => ['required', 'exists:friends,id'],
            'lent_at' => ['required', 'date'],
            // Business rule: Due date must be in the future AND not before lent_at
            'due_at' => [
                'required',
                'date',
                'after:today',
                'after_or_equal:lent_at',
            ],
        ];
    }
}
