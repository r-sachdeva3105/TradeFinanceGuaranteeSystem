@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Guarantees Pending Review</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($guarantees->isEmpty())
        <p>No guarantees available for review.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Corporate Reference Number</th>
                    <th>Guarantee Type</th>
                    <th>Nominal Amount</th>
                    <th>Applicant Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guarantees as $guarantee)
                <tr>
                    <td>{{ $guarantee->corporate_reference_number }}</td>
                    <td>{{ $guarantee->guarantee_type }}</td>
                    <td>{{ $guarantee->nominal_amount }} {{ $guarantee->nominal_amount_currency }}</td>
                    <td>{{ $guarantee->applicant_name }}</td>
                    <td>
                        <!-- Action Buttons Container -->
                        <div class="btn-container">
                            <!-- Approve Form -->
                            <form action="{{ route('reviewer.guarantees.update', $guarantee->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" name="approve" class="btn btn-success">Approve</button>
                            </form>

                            <!-- Reject Form -->
                            <form action="{{ route('reviewer.guarantees.update', $guarantee->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                            </form>
                        </div>

                        <!-- Remarks Textarea Container (Below Buttons) -->
                        <div class="remarks-container mt-3">
                            <textarea name="remarks" placeholder="Enter remarks" class="form-control" required></textarea>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
