@extends('layouts.app')

@section('content')
    @if (Auth::check())
        <div class="row">
            <aside class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ Auth::user()->name }}</h3>
                    </div>
                    <div class="card-body">
                        {{-- 認証済みユーザのメールアドレスをもとにGravatarを取得して表示 --}}
                        <img class="rounded img-fluid" src="{{ Gravatar::get(Auth::user()->email, ['size' => 500]) }}" alt="">
                    </div>
                </div>
            </aside>
            <div class="col-sm-8">
                <h1>タスク一覧</h1>
                    @if (count($tasks) > 0)
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>ステータス</th>
                                    <th>タスク</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tasks as $task)
                                    <tr>
                                        {{-- タスク詳細ページへのリンク --}}
                                        <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                                        <td>{{ $task->status }}</td>
                                        <td>{{ $task->content }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
            
                        {{-- ページネーションのリンク --}}
                        {{ $tasks->links() }}
                                    
                        {{-- タスク登録ページへのリンク --}}
                        {!! link_to_route('tasks.create', '新規タスクの登録', [], ['class' => 'btn btn-primary']) !!}
                    @endif
            </div>
        </div>
    @endif