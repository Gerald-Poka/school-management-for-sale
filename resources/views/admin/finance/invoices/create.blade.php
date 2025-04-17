@extends('layouts.master')
@section('title') Create Invoice @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Create Invoice @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Create New Invoice</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.finance.invoices.store') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Student</label>
                                <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                    <option value="">Select Student</option>
                                    @forelse($students as $student)
                                        <option value="{{ $student->id }}">
                                            {{ $student->first_name }} {{ $student->last_name }} 
                                            @if($student->admission_number)
                                                ({{ $student->admission_number }})
                                            @endif
                                            @if($student->academicLevel)
                                                - {{ $student->academicLevel->name }}
                                            @endif
                                        </option>
                                    @empty
                                        <option disabled>No students found</option>
                                    @endforelse
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Invoice Date</label>
                                <input type="date" name="invoice_date" class="form-control" required 
                                       value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Due Date</label>
                                <input type="date" name="due_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="fee-items-table">
                                        <thead>
                                            <tr>
                                                <th>Fee Type</th>
                                                <th width="200">Amount</th>
                                                <th width="100">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="items[0][fee_structure_id]" class="form-select fee-type-select" required>
                                                        <option value="">Select Fee Type</option>
                                                        @foreach($feeStructures as $fee)
                                                            <option value="{{ $fee->id }}" data-amount="{{ $fee->amount }}">
                                                                {{ $fee->feeType->name }} - {{ $fee->academicLevel->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="items[0][amount]" class="form-control" 
                                                           step="0.01" min="0" required>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger remove-row">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <button type="button" class="btn btn-sm btn-success" id="add-row">
                                                        <i class="ri-add-line"></i> Add Item
                                                    </button>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="text-end">
                                    <a href="{{ route('admin.finance.invoices.index') }}" class="btn btn-secondary me-1">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Create Invoice</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowCount = 1;
        
        // Function to handle fee type selection
        function handleFeeTypeSelection(select) {
            const row = select.closest('tr');
            const amountInput = row.querySelector('input[name*="[amount]"]');
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption.dataset.amount) {
                amountInput.value = selectedOption.dataset.amount;
            }
        }
        
        // Add event listener to existing fee type select
        document.querySelectorAll('.fee-type-select').forEach(select => {
            select.addEventListener('change', function() {
                handleFeeTypeSelection(this);
            });
        });
        
        // Add new row
        document.getElementById('add-row').addEventListener('click', function() {
            const tbody = document.querySelector('#fee-items-table tbody');
            const template = tbody.querySelector('tr').cloneNode(true);
            
            // Update input names
            template.querySelectorAll('[name]').forEach(input => {
                input.name = input.name.replace('[0]', `[${rowCount}]`);
                input.value = '';
            });
            
            // Add event listener to new fee type select
            const newSelect = template.querySelector('.fee-type-select');
            newSelect.addEventListener('change', function() {
                handleFeeTypeSelection(this);
            });
            
            tbody.appendChild(template);
            rowCount++;
        });
        
        // Remove row
        document.querySelector('#fee-items-table').addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const tbody = this.querySelector('tbody');
                if (tbody.children.length > 1) {
                    e.target.closest('tr').remove();
                }
            }
        });
    });
</script>
@endsection