<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class TaskController extends Controller
{
  
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function store(StoreRequest $request)
    {
        try {
            \DB::beginTransaction();
            $task = Task::create([
                'title' =>  $request->title
            ]);
            \DB::commit();
            return response()->json([
                'status' => 200,
                'task'   => $task->toArray()
            ], 200);
        }catch (\Exception $exception){
            \DB::rollBack();
            return response()->json([
                'status' => 500
            ], 500);
        }
    }

   

    public function update(StoreRequest $request, Task $task)
    {
        try {
            \DB::beginTransaction();
           $task->update([
               'title'  =>  $request->title
           ]);
            \DB::commit();
            return response()->json([
                'status' => 200,
                'title'  => $request->title
            ], 200);
        }catch (\Exception $exception){
            \DB::rollBack();
            return response()->json([
                'status' => 500
            ], 500);
        }
    }

    public function destroy(Task $task)
    {
        try {
            \DB::beginTransaction();
            $task->delete();
            \DB::commit();
            return response()->json([
                'status' => 200
            ], 200);
        }catch (\Exception $exception){
            \DB::rollBack();
            return response()->json([
                'status' => 500
            ], 500);
        }
    }
}
