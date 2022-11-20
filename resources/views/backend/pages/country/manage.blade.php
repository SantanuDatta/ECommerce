@extends('backend.layout.template')

@section('title', 'All Countries')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-world-outline tx-70 lh-0"></i>
        <div>
        <h4>Countries</h4>
        <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Manage All Countries
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">
                        
                        @if ($countries->count() == 0)
                            <div class="alert alert-info">No Countries Are Uploaded Yet!</div>
                        @else
                            <table id="data" class="table table-striped table-hover table-bordered table-responsive-xl">
                                <thead>
                                    <tr>
                                        <th scope="col">#SL.</th>
                                        <th scope="col">Country Name</th>
                                        <th scope="col">Priority</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $serial = 1; @endphp
                                    @foreach ($countries as $country)
                                        <tr>
                                            <th scope="row">{{ $serial }}</th>
                                            
                                            <td>{{ $country->name }}</td>
                                            <td>{{ $country->priority }}</td>
                                            <td>@if ($country->status == 1)
                                                <span class="badge badge-success">Active</span>
                                            @elseif ($country->status == 0)
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif</td>
                                            <td>
                                                <div class="btn-group action-bar" role="group">
                                                    <a href="{{ route('country.edit', $country->id) }}"><i class="fas fa-edit"></i></a>
                                                    <a href="" data-toggle="modal" data-target="#deleteCountry-{{ $country->id }}"><i class="fas fa-trash"></i></a>
                                                </div>
                                                
                                                <!-- Delete Modal -->
                                                <div class="modal fade effect-scale modal-dark" id="deleteCountry-{{ $country->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                    <div class="modal-content bd-0">
                                                        <div class="modal-header pd-x-20">
                                                        <h5 class="modal-title" id="deleteModalLabel">Delete Country</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body pd-20">
                                                            <p class="mg-b-5">
                                                                This Country Will Be Removed Completely
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                                        <form action="{{ route('country.destroy', $country->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" name="status" class="btn btn-danger btn-sm" >Delete Country</button>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @php $serial++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        
                    </div><!-- card-body -->
                </div><!-- card -->
            </div>
        </div>
    </div>
@endsection