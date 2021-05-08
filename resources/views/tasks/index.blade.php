@extends('master')

@section('contents')
    <h1>Here is all list of tasks</h1>
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" class="form-control" placeholder="Enter task title ..." id="title">
                </div>
                <div class="col-md-2" id="btnDiv">
                    <button type="button" id="submit" onclick="storeNewTask()" class="btn btn-success btn-block">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
       <div class="col-md-12" id="task-place">
           @foreach($tasks as $task)
               <div class="card bg-light text-dark mt-3" id="task{{ $task->id }}">
                   <div class="card-body">
                    <span class="left span-task-{{ $task->id }}">
                        {{ $task->title }}
                    </span>
                       <span class="right">
                        <button class="btn btn-sm btn-danger" onclick="deleteTask({{ $task->id }})">delete</button>
                        <button class="btn btn-sm btn-primary edit-task edit-task-{{ $task->id }}" data-task="{{ $task->id }}" data-title="{{ $task->title }}">edit</button>
                    </span>
                   </div>
               </div>
           @endforeach
       </div>
    </div>
@endsection

@push('scripts')
    <script>
        const deleteTask = async (task) => {
            await fetch('/task/' + task, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({task}),
            })
            .then((response) => response.json())
            .then(responseData => {
                if (responseData['status'] != 200)
                    return alert('There is a problem ...');

                $('#task' + task).remove();

            })
            .catch(error => {
                console.log(error);
            });
        };

        $(document).ready(function (){
            $(".edit-task").on('click', function (){
                let taskId = $(this).attr('data-task');
                let taskTitle = $(this).attr('data-title');
                let submit = $('#submit');
                let divBtn = $('#btnDiv');
                $('#title').val(taskTitle);
                if (submit.length == 0){
                    return $("#edit").attr("onclick",`edit(${taskId})`);
                }
                submit.remove();
                divBtn.append(`<button type="button" id="edit" onclick="edit(${taskId})" class="btn btn-info mr-2">edit</button>`);
                divBtn.append(`<button type="button" id="newTask" class="btn btn-primary" onclick="newTask()">new</button>`);
            });
        });

        const edit = (taskId) => {
            let task = document.getElementById("title");

            if (task.value == '')
                return alert('Please enter task title');

            let result = updateTask(taskId, task.value);

            result
                .then(response => response.json())
                .then(responseData => {

                    if (responseData['status'] != 200)
                        return alert('There is a problem ...');


                    $('.span-task-' + taskId).html(responseData['title']);
                    $('#title').val('');
                    $('#newTask').remove();
                    $('#edit').remove();
                    let divBtn = $('#btnDiv');
                    $('.edit-task-' + taskId).attr('data-title', responseData['title']);
                    divBtn.append(`<button id="submit" type="button" onclick="storeNewTask()" class="btn btn-success btn-block">Submit</button>`);

                })
                .catch(error => {
                    console.log(error);
                });
        }

        const newTask = () => {
            $('#newTask').remove();
            $('#edit').remove();
            let divBtn = $('#btnDiv');
            divBtn.append(`<button id="submit" type="button" onclick="storeNewTask()" class="btn btn-success btn-block">Submit</button>`);
            $('#title').val('');
        };


        const addTask = (task) => {
            $("#task-place").append(`
            <div class="card bg-light text-dark mt-3" id="task${task['id']}">
                <div class="card-body">
                    <span class="left">
                        ${task['title']}
                    </span>
                    <span class="right">
                        <button class="btn btn-sm btn-danger" onclick="deleteTask(${task['id']})">delete</button>

                    </span>
                </div>
            </div>
            `);
        };

        const storeTask = async (title) => {
            return await fetch('/task', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({title})
            });
        };

        const updateTask = async (id, title) => {
            return await fetch('/task/' + id, {
                method: 'PUT',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify({title})
            });
        };

        const storeNewTask = () => {
            let task = document.getElementById("title");

            if (task.value == '')
                return alert('Please enter task title');

            let result = storeTask(task.value);

            result
                .then(response => response.json())
                .then(responseData => {

                    if (responseData['status'] != 200)
                        return alert('There is a problem ...');

                    addTask(responseData['task']);
                    $('#title').val('');

                })
                .catch(error => {
                    console.log(error);
                });
        };
    </script>
@endpush
