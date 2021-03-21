<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{

  public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            // （後のChapterで他ユーザの投稿も取得するように変更しますが、現時点ではこのユーザの投稿のみ取得します）
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
        }

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
    }


    public function destroy($id)
    {
        // idの値で投稿を検索して取得
        $task = \App\Tasklist::findOrFail($id);

        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }

        // 前のURLへリダイレクトさせる
        return back();
    }

}