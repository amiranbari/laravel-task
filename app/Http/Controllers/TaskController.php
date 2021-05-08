<?php

namespace App\Http\Controllers;

use App\Http\Requests\Task\StoreRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
