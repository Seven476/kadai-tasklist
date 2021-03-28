@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-8">
            <ul class="nav nav-tabs nav-justified mb-3">
                {{-- ユーザ詳細タブ --}}
                <li class="nav-item">
                    <a href="{{ route('users.show', ['user' => $user->id]) }}" class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}">
                        TimeLine
                        <span class="badge badge-secondary">{{ $user->tasklist_count }}</span>
                    </a>
                </li>
            </ul>
            @if (Auth::id() == $user->id)
                {{-- 投稿フォーム --}}
                @include('tasks.create')
            @endif
            {{-- 投稿一覧 --}}
            @include('tasks.tasklist')
        </div>
    </div>
@endsection