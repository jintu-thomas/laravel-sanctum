<?php

namespace App\Http\Controllers;
use App\Todo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $todos=Todo::all();

        return view('home',['todos'=>$todos]);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title'=>'required|max:200',
        ]);
        Todo::create($validateData);
        // $todo = new Todo;
        // $todo->title=$request->title;
        // $todo->save();
        return redirect('home');
    }

    public function edit(Todo $todo)
    {
        return view('update', compact('todo'));
        
    }
    public function update(Request $request, Todo $todo) 
    {
        $validateData = $request->validate([
            'title'=>'required|max:200',
        ]);
        
        $todo->title = $validateData['title'];
        $todo->save();
        return redirect(route('index'));
    }

    public function delete(Todo $todo)
    {
        $todo->delete();
        return redirect(route('index'));
    }

    
}