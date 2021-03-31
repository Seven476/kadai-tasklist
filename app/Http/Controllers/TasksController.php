<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{

 public function index()
    {
        
        $task;
        $tasks;
         
        $data = [];
        
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('tasks.index', $data);
    }
    
    public function create()
    {
        $task = new Task;

        // タスク登録ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }
    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10', 
            'content' => 'required|max:140', 
        ]);
        
        $request->user()->tasks()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);

        // 前のURLへリダイレクトさせる
        return redirect('/');
    }
    
    public function show($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        // タスク詳細ビューでそれを表示
        if (\Auth::id() === $task->user_id ) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
    }
    
    public function edit($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は
        if (\Auth::id() === $task->user_id) {
            // メッセージ編集ビューでそれを表示
             return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        
         return redirect('/');
    }
    
    public function update(Request $request, $id)
    {
        
        // バリデーション
        $request->validate([
            'status' => 'required|max:10', 
            'content' => 'required|max:140', 
        ]);
    
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、
        if (\Auth::id() === $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }
        
        return redirect('/');
    }

    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $task = Task::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // 前のURLへリダイレクトさせる
         return redirect('/');
    }

}