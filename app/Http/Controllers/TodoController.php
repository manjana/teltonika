<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

/**
 * Class TodoController
 * @package App\Http\Controllers
 */
class TodoController extends Controller
{
    /**
     * @return Response
     */
    public function addTodo(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'data' => 'required|string',
        ]);

        $todoData = $request->only(['data']);
        $todo = new Todo();
        $todo->data = $todoData['data'];
        $user = Auth::user();

        $user->todo()->save($todo);

        return response()->json(['todo' => $todo, 'message' => 'Todo succesfuly created'], 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateTodo(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'id' => 'required|integer|exists:todo',
            'data' => 'required|string',
        ]);

        $todoData = $request->only(['id', 'data']);

        $user = Auth::user();
        $todo = Todo::where(['user_id' => $user->id, 'id' => $todoData['id']])->first();

        if (!$todo) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $todo->data = $todoData['data'];
        $todo->save();

        return response()->json(['todo' => $todo, 'message' => 'Todo succesfuly updated'], 200);
    }

    public function deleteTodo(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'id' => 'required|integer|exists:todo'
        ]);

        $todoData = $request->only(['id']);

        Todo::destroy($todoData['id']);

        return response()->json(['message' => 'Todo succesfuly deleted'], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function todoList()
    {
        return response()->json(['todos' => Todo::with('user')->get()], 200);
    }
}
