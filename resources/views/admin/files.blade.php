@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row h-screen">
        <!-- Sidebar -->
        <aside class="col-md-2 p-0 vh-100">
            <div class="bg-dark text-white p-4 h-100">
                <h1 class="text-center bold">Admin Panel</h1>
                <ul class="list-unstyled text-center mt-5">
                    <li><a href="{{ route('dashboard.admin') }}" class="text-white h4 text-decoration-none d-block p-2">Dashboard</a></li>
                    <li><a href="{{ route('admin.users') }}" class="text-white h4 text-decoration-none d-block p-2">Users</a></li>
                    <li><a href="{{ route('admin.guarantees') }}" class="text-white h4 text-decoration-none d-block p-2">Guarantees</a></li>
                    <li><a href="{{ route('admin.files') }}" class="text-white h4 text-decoration-none d-block p-2">Files</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="content p-4">
                <h1>Manage Files</h1>

                @if(session('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
                @endif

                <!-- Upload File Form -->
                <div class="row mb-4">
                    <div class="col">
                        <form action="{{ route('files.upload') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                            @csrf
                            <div class="form-group me-3">
                                <input type="file" class="form-control" name="file" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload File</button>
                        </form>
                    </div>
                </div>

                <!-- Files Table -->
                <h3>Uploaded Files</h3>
                <table class="table table-bordered table-striped mt-4">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>File Type</th>
                            <th>Upload Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->name }}</td>
                            <td>{{ strtoupper($file->type) }}</td>
                            <td>{{ $file->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <a href="{{ route('files.download', $file->id) }}" class="btn btn-success btn-sm">Download</a>

                                <!-- Parse File Button -->
                                @if($file->type == 'csv')
                                <form action="{{ route('files.parse', $file->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm">Parse</button>
                                </form>
                                @endif

                                <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection