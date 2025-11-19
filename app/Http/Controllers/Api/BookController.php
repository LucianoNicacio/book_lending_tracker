<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string|max:255',
            'author'   => 'required|string|max:255',
            'isbn'     => [
                'required',
                'string',
                'regex:/^\d{10}(\d{3})?$/', // 10 or 13 digits
                'unique:books,isbn',
            ],
            'added_at' => 'required|date',
        ]);

        $book = Book::create($data);

        return response()->json($book, 201);
    }
}
