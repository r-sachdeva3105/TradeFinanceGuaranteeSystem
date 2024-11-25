@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row h-screen">
        <!-- Sidebar -->
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
        <!-- Main Content -->
        <div class="col-md-10">
            <div class="content p-4">
                <h1>Manage Guarantees</h1>

                @if(session('message'))
                <div class="alert alert-info">
                    {{ session('message') }}
                </div>
                @endif

                <!-- Create New Guarantee Button -->
                <div class="row mb-4">
                    <div class="col">
                        <button id="createGuaranteeBtn" class="btn btn-primary" onclick="toggleGuaranteeForm()">Create New Guarantee</button>
                    </div>
                </div>

                <!-- Guarantees Table -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Corporate Reference</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Currency</th>
                            <th>Expiry Date</th>
                            <th>Applicant</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guarantees as $guarantee)
                        <tr>
                            <td>{{ $guarantee->corporate_reference_number }}</td>
                            <td>{{ $guarantee->guarantee_type }}</td>
                            <td>{{ $guarantee->nominal_amount }}</td>
                            <td>{{ $guarantee->nominal_amount_currency }}</td>
                            <td>{{ $guarantee->expiry_date }}</td>
                            <td>{{ $guarantee->applicant_name ?? 'Unknown' }}</td> <!-- Fetch the applicant name from user -->
                            <td>{{ ucfirst($guarantee->status) }}</td> <!-- Display the status -->
                            <td>
                                <form action="{{ route('guarantees.destroy', $guarantee->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Guarantee Form -->
                <div id="guaranteeForm" style="display:none;">
                    <h3 id="formTitle">Create New Guarantee</h3>
                    <form id="guaranteeFormElement" action="{{ route('guarantees.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="corporate_reference_number" class="form-label">Corporate Reference Number</label>
                            <input type="text" class="form-control" id="corporate_reference_number" name="corporate_reference_number" required>
                        </div>
                        <div class="mb-3">
                            <label for="guarantee_type" class="form-label">Guarantee Type</label>
                            <input type="text" class="form-control" id="guarantee_type" name="guarantee_type" required>
                        </div>
                        <div class="mb-3">
                            <label for="nominal_amount" class="form-label">Nominal Amount</label>
                            <input type="number" class="form-control" id="nominal_amount" name="nominal_amount" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="nominal_amount_currency" class="form-label">Currency</label>
                            <input type="text" class="form-control" id="nominal_amount_currency" name="nominal_amount_currency" required>
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date</label>
                            <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="applicant_name" class="form-label">Applicant Name</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="applicant_address" class="form-label">Applicant Address</label>
                            <input type="text" class="form-control" id="applicant_address" name="applicant_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="beneficiary_name" class="form-label">Beneficiary Name</label>
                            <input type="text" class="form-control" id="beneficiary_name" name="beneficiary_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="beneficiary_address" class="form-label">Beneficiary Address</label>
                            <input type="text" class="form-control" id="beneficiary_address" name="beneficiary_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Applicant</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">Select Applicant</option>
                                @foreach($applicants as $applicant)
                                <option value="{{ $applicant->id }}">{{ $applicant->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Save Guarantee</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelGuaranteeEdit()">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('other-scripts')
<script type="text/javascript">
    function toggleGuaranteeForm() {
        const guaranteeForm = $('#guaranteeForm');
        $('#submitGuaranteeBtn').text('Create Guarantee');
        if (guaranteeForm.is(':hidden')) {
            guaranteeForm.show();
        } else {
            guaranteeForm.hide();
        }
    }

    function cancelGuaranteeEdit() {
        $('#guaranteeForm').hide();
        $('#createGuaranteeBtn').show();
        $('#guaranteeFormElement')[0].reset();
    }
</script>
@endpush