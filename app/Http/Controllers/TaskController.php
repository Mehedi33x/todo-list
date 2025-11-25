<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        // function for greetings
        $hour = Carbon::now()->hour;
        // dd($hour);
        $greeting = '';
        if ($hour >= 0 && $hour < 12) {
            $greeting = "Good Morning";
        } else if ($hour >= 12 && $hour < 15) {
            $greeting = "Good Noon";
        } else if ($hour >= 15 && $hour < 18) {
            $greeting = "Good Afternoon";
        } else {
            $greeting = "Good Evening";
        }

        $tasks = Task::where('user_id', auth()->user()->id)->latest()->get();
        return view('tasks.index', compact('tasks', 'greeting'));
    }

    public function store(Request $request)
    {
        // dd(auth()->user()->id);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
        if (auth()->check()) {
            $data = $request->all();
            $data['user_id'] = auth()->user()->id;
            $task = Task::create($data);
            if ($task) {
                return redirect()->route('task.index')->with('success', 'Your Task has been added');
            }
            return redirect()->back()->with('error', 'Something went wrong');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function update(Request $request, Task $task)
    {
        if ($task) {
            $task->update($request->all());
            return redirect()->back()->with('success', 'Task completed successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');

    }

    public function destroy(Task $task)
    {
        if ($task) {
            $task->delete();
            return redirect()->back()->with('success','Task deleted successfully');
        }
        return redirect()->back()->with('error', 'Something went wrong');
    }
}
