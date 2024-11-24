@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row h-screen">
        <!-- Sidebar (Admin Navigation) -->
        <aside class="col-md-2 p-0 vh-100">
            <div class="bg-dark text-white p-4 h-100">
                <h1 class="text-center font-weight-bold">Admin Panel</h1>
                <ul class="list-unstyled text-center mt-5">
                    <li><a href="{{ route('dashboard.admin') }}" class="text-white h4 text-decoration-none d-block p-2">Dashboard</a></li>
                    <li><a href="{{ route('admin.users') }}" class="text-white h4 text-decoration-none d-block p-2">Users</a></li>
                    <li><a href="{{ route('admin.guarantees') }}" class="text-white h4 text-decoration-none d-block p-2">Guarantees</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="col-md-10">
            <div class="content p-4">
                <h1>Manage Users</h1>

                @if(isset($message))
                <div class="alert alert-info">
                    {{ $message }}
                </div>
                @endif

                <!-- Create New User Button -->
                <div class="row mb-4">
                    <div class="col">
                        <button id="createUserBtn" class="btn btn-primary" onclick="toggleForm()">Create New User</button>
                    </div>
                </div>

                <!-- Users Table -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-capitalize">{{ $user->user_type }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editUser('{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}', '{{ $user->user_type }}')">Edit</button>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- User Form (Create/Edit) -->
                <div id="userForm" style="display:none;">
                    <h3 id="formTitle">Create New User</h3>
                    <form id="userFormElement" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="userId" name="userId">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_type" class="form-label">Role</label>
                            <select class="form-control" id="user_type" name="user_type" required>
                                <option value="applicant">Applicant</option>
                                <option value="reviewer">Reviewer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success" id="submitBtn">Create User</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('other-scripts')
<script type="text/javascript">
    function toggleForm() {
        const userForm = $('#userForm');
        $('#submitBtn').text('Create User');
        if (userForm.is(':hidden')) {
            userForm.show();
        } else {
            userForm.hide();
        }
    }

    function editUser(id, name, email, userType) {
        $('#formTitle').text('Edit User');
        $('#userId').val(id);
        $('#name').val(name);
        $('#email').val(email);
        $('#user_type').val(userType);
        $('#userForm').show();
        $('#createUserBtn').hide();
        $('#submitBtn').text('Update User');
        $('#userFormElement').attr('action', 'users/' + id + '/edit');
    }

    function cancelEdit() {
        $('#userForm').hide();
        $('#createUserBtn').show();
        $('#userFormElement')[0].reset();
    }
</script>
@endpush