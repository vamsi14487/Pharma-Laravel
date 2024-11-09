@extends('Admin.home')

@section('bar')
    <span class="text-muted float-right">Home / Medicine List</span>
@endsection

@section('connect')
    @if (Session::get('message'))
        <div class="row">
            <div class="col-12 col-lg-6 ml-lg-auto">
                <div class="alert alert-success alert-dismissible fade show mt-2 " role="alert" id="errorAlert">
                    <strong>{{ Session::get('message') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <span class="font-weight-bold">Medicine List</span>
            <a href="{{ url('admin-dashboard') }}" class="btn btn-primary float-right">Back</a>
        </div>

        <div class="card-body">
            <div>
                <a href="{{ url('add-medicine') }}" class="float-right btn btn-primary mb-3">Add Medicine</a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead class="table-dark">
                        <th scope="col">#</th>
                        <th scope="col">Drugs Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Discount (%)</th>
                        <th scope="col">Discounted Price</th> <!-- New column for discounted price -->
                        <th scope="col" colspan="2" class="text-center">Action</th>
                    </thead>

                    @php $i = 1 @endphp

                    <tbody>
                        @forelse ($medicine as $row)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $row->drugs }}</td>
                            <td>{{ $row->amount }}</td>
                            <td>{{ $row->discount }}%</td>
                            <td>
                                <!-- Correct discount calculation -->
                                @php
                                    $discountedPrice = $row->amount * (1 - $row->discount / 100);
                                @endphp
                                {{ number_format($discountedPrice, 2) }} <!-- Format to 2 decimal places -->
                            </td>
                            <td class="text-center">
                                <a href="" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</a>
                            </td>
                            <td>
                                <!-- Form to handle delete request -->
                                <form action="{{ route('medicine.delete', $row->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-danger text-center">No Data Record</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $medicine->links() }}
        </div>
    </div>
@endsection

@section('alertHide')
    $('#errorAlert').hide(4000).slideUp(400);
@endsection
