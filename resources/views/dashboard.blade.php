@extends('layouts2.app')

@section('title', 'Dashboard')

@section('content')

    @role('admin')
    
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
            Manage Users
        </a>

    @endrole


@endsection