@extends('layouts.master')
@section('title') Other Fees @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Other Fees @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">Other Fees Structure</h4>
                    <div class="float-end">
                        <a href="{{ route('admin.finance.other-fees.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i> Add New Fee
                        </a>
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Fee Type</th>
                                    <th>Academic Level</th>
                                    <th>Amount (TSh)</th>
                                    <th>Frequency</th>
                                    <th>Effective Period</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($otherFees as $fee)
                                    <tr>
                                        <td>{{ $fee->feeType->name }}</td>
                                        <td>{{ $fee->academicLevel->name }}</td>
                                        <td>{{ number_format($fee->amount, 2) }}</td>
                                        <td>{{ ucfirst($fee->feeType->frequency) }}</td>
                                        <td>
                                            {{ $fee->effective_from->format('d/m/Y') }} - 
                                            {{ $fee->effective_to ? $fee->effective_to->format('d/m/Y') : 'Ongoing' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $fee->is_active ? 'success' : 'danger' }}">
                                                {{ $fee->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.finance.other-fees.edit', $fee->id) }}" class="btn btn-sm btn-info" title="Edit">
            <i class="ri-pencil-fill"></i>
        </a>
        
        <form action="{{ route('admin.finance.other-fees.destroy', $fee->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" title="Delete"
                    onclick="return confirm('Are you sure you want to delete this fee?')">
                <i class="ri-delete-bin-fill"></i>
            </button>
        </form>
    </div>
</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No other fees found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection