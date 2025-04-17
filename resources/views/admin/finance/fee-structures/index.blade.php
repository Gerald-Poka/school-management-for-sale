@extends('layouts.master')
@section('title') Fee Structures @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Fee Structures @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">Fee Structures</h4>
                    <div class="float-end">
                        <a href="{{ route('admin.finance.fee-structures.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i> Add New Fee Structure
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Academic Level</th>
                                    <th>Fee Type</th>
                                    <th>Amount (TSh)</th>
                                    <th>Effective Period</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeStructures as $feeStructure)
                                    <tr>
                                        <td>{{ $feeStructure->academicLevel->name }}</td>
                                        <td>{{ $feeStructure->feeType->name }}</td>
                                        <td>{{ number_format($feeStructure->amount, 2) }}</td>
                                        <td>
                                            {{ $feeStructure->effective_from->format('d/m/Y') }} - 
                                            {{ $feeStructure->effective_to ? $feeStructure->effective_to->format('d/m/Y') : 'Ongoing' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $feeStructure->is_active ? 'success' : 'danger' }}">
                                                {{ $feeStructure->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.finance.fee-structures.edit', $feeStructure) }}">
                                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.finance.fee-structures.destroy', $feeStructure) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this fee structure?')">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No fee structures found</td>
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