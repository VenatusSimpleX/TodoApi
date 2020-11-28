<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user())->first();

        return $user->todos;
    }

    public function store()
    {
        $validator = Validator::make(request(['description']), [
            'description' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Todo::create([
            'description' => $description = request()->description,
            'done' => false,
            'hash' => sha1(now() . $description)
        ]);

        return response()->json([
            'message' => 'Todo created successfully'
        ], 201);
    }

    public function show(Todo $todo)
    {
        if (auth()->user()->id !== $todo->user->id) {
            return response()->json([
                'error' => 'Not found'
            ], 404);
        }

        return response()->json($todo);
    }

    function update(Todo  $todo)
    {
        if (auth()->user()->id !== $todo->user->id) {
            return response()->json([
                'error' => 'Not found'
            ], 404);
        }

        $validator = Validator::make(request(['description', 'done']), [
            'description' => 'required|max:255',
            'done' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $todo->description = request()->description;
        $todo->save();

        return response()->json([
            'message' => 'Todo updated successfully'
        ], 200);
    }

    public function destroy(Todo $todo)
    {
        if (auth()->user()->id !== $todo->user->id) {
            return response()->json([
                'error' => 'Not found'
            ], 404);
        }

        $todo->delete();

        return response()->json([
            'message' => 'Todo deleted successfully'
        ], 200);
    }
}
