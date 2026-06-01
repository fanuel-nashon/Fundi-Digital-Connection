@extends('layouts.admin')
@section('title','Users')
@section('page-title','User Management')

@section('content')
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <span><i class="bi bi-people me-2 text-muted"></i>All Users <span class="text-muted fw-normal">({{ count($users) }})</span></span>
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-brand">
            <i class="bi bi-person-plus me-1"></i>Create User
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead>
                <tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Location</th><th>Joined</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td class="text-muted small">{{ $i + 1 }}</td>
                    <td class="fw-medium">{{ $user->name }}</td>
                    <td class="text-muted small">{{ $user->email }}</td>
                    <td>
                        <span class="badge badge-role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td class="text-muted small">{{ $user->location ?? '—' }}</td>
                    <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user->id) }}"
                           class="btn btn-sm btn-outline-secondary me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form id="del-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                        </form>
                        <button class="btn btn-sm btn-outline-danger"
                                onclick="swalDelete('del-{{ $user->id }}', '{{ addslashes($user->name) }}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
