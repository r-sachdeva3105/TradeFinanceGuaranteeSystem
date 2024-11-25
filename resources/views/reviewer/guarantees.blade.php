@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="content p-4">
        <h1>Guarantee Details</h1>
        <table class="table table-bordered">
            <tr>
                <th>Corporate Reference Number</th>
                <td>{{ $guarantee->corporate_reference_number }}</td>
            </tr>
            <tr>
                <th>Guarantee Type</th>
                <td>{{ $guarantee->guarantee_type }}</td>
            </tr>
            <tr>
                <th>Nominal Amount</th>
                <td>{{ $guarantee->nominal_amount }} {{ $guarantee->nominal_amount_currency }}</td>
            </tr>
            <tr>
                <th>Expiry Date</th>
                <td>{{ $guarantee->expiry_date }}</td>
            </tr>
            <tr>
                <th>Applicant Name</th>
                <td>{{ $guarantee->applicant_name }}</td>
            </tr>
            <tr>
                <th>Applicant Address</th>
                <td>{{ $guarantee->applicant_address }}</td>
            </tr>
            <tr>
                <th>Beneficiary Name</th>
                <td>{{ $guarantee->beneficiary_name }}</td>
            </tr>
            <tr>
                <th>Beneficiary Address</th>
                <td>{{ $guarantee->beneficiary_address }}</td>
            </tr>
        </table>

        <!-- Update Guarantee Form -->
        <form action="{{ route('reviewer.guarantees.update', $guarantee->id) }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks (for rejection)</label>
                <textarea class="form-control" id="remarks" name="remarks" placeholder="Enter remarks if rejecting" rows="3"></textarea>
            </div>

            <!-- Approve Button -->
            <button type="submit" name="approve" value="approve" class="btn btn-success">Approve</button>

            <!-- Reject Button -->
            <button type="submit" name="reject" value="reject" class="btn btn-danger">Reject</button>
        </form>

        <!-- Back to Dashboard Button -->
        <a href="{{ route('dashboard.reviewer') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
</div>
@endsection