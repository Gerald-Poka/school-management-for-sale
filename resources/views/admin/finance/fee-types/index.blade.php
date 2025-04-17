@extends('layouts.master')
@section('title') Fee Types @endsection
@section('content')
@component('components.breadcrumb')
    @slot('li_1') Finance @endslot
    @slot('title') Fee Types @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">Fee Types</h4>
                    <div class="float-end">
                        <a href="{{ route('admin.finance.fee-types.create') }}" class="btn btn-primary">
                            <i class="ri-add-line align-bottom me-1"></i> Add New Fee Type
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Description</th>
                                    <th>Frequency</th>
                                    <th>Mandatory</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeTypes as $feeType)
                                    <tr>
                                        <td>{{ $feeType->name }}</td>
                                        <td>{{ $feeType->code }}</td>
                                        <td>{{ $feeType->description }}</td>
                                        <td>{{ ucfirst($feeType->frequency) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $feeType->is_mandatory ? 'info' : 'warning' }}">
                                                {{ $feeType->is_mandatory ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-2-fill"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('admin.finance.fee-types.edit', $feeType) }}">
                                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.finance.fee-types.destroy', $feeType) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this fee type?')">
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
                                        <td colspan="6" class="text-center">No fee types found</td>
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