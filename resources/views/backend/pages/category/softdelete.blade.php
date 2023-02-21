@extends('backend.layout.template')

@section('title', 'Deleted Categories')
@section('body-content')
    <div class="br-pagetitle">
        <i class="icon ion-ios-list-outline tx-70 lh-0"></i>
        <div>
            <h4>Deleted Categories</h4>
            <p class="mg-b-0">Do bigger things with Bracket plus, the responsive bootstrap 4 admin template.</p>
        </div>
    </div><!-- d-flex -->

    <div class="br-pagebody">
        <div class="row row-sm mg-b-20">
            <div class="col-sm-12">
                <div class="card bd-0">
                    <div class="card-header tx-medium bd-0 tx-white">
                        Soft Deleted Categores
                    </div><!-- card-header -->
                    <div class="card-body bd bd-t-0 rounded-bottom">

                        @if ($categories->count() == 0)
                            <div class="alert alert-info">No Deleted Categories Found!</div>
                        @else
                            <table id="data"
                                class="table table-striped table-hover table-bordered table-responsive-xl">
                                <thead>
                                    <tr>
                                        <th scope="col">#SL.</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Category Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $serial = 1;
                                    @endphp
                                    @foreach ($categories as $pCat)
                                        <tr>
                                            <th scope="row">{{ $serial }}</th>
                                            <td>
                                                @if (is_null($pCat->image))
                                                    <img src="{{ asset('backend/img/categories/Default.png') }}"
                                                        alt="" class="img-fluid rounded-circle table-image">
                                                @else
                                                    <img src="{{ asset('backend/img/categories/' . $pCat->image) }}"
                                                        class="img-fluid rounded-circle table-image">
                                                @endif
                                            </td>
                                            <td>{{ $pCat->name }}</td>
                                            <td>
                                                @if ($pCat->status == 2)
                                                    <span class="badge badge-warning">Soft Deleted</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group action-bar" role="group">
                                                    <a href="" data-toggle="modal"
                                                        data-target="#description-{{ $pCat->id }}"><i
                                                            class="fas fa-eye"></i></a>
                                                    <a href="{{ route('category.edit', $pCat->id) }}"><i
                                                            class="fas fa-edit"></i></a>
                                                    <a href="" data-toggle="modal"
                                                        data-target="#fulldelete-{{ $pCat->id }}"><i
                                                            class="fas fa-trash"></i></a>
                                                </div>
                                                <!-- View Modal -->
                                                <div class="modal fade effect-scale modal-dark"
                                                    id="description-{{ $pCat->id }}" tabindex="-1"
                                                    aria-labelledby="viewModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content bd-0">
                                                            <div class="modal-header pd-x-20">
                                                                <h5 class="modal-title" id="viewModalLabel">Category
                                                                    Descripton</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body pd-20">
                                                                <p class="mg-b-5">
                                                                    @if (!$pCat->description)
                                                                        No Description Added
                                                                    @else
                                                                        {!! $pCat->description !!}
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Full Delete Modal -->
                                                <div class="modal fade effect-scale modal-dark"
                                                    id="fulldelete-{{ $pCat->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content bd-0">
                                                            <div class="modal-header pd-x-20">
                                                                <h5 class="modal-title" id="deleteModalLabel">Full Delete
                                                                    Category</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body pd-20">
                                                                <p class="mg-b-5">
                                                                    Category Will Be Removed But You Can Activate It Back
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm"
                                                                    data-dismiss="modal">Close</button>
                                                                <form action="{{ route('category.fulldelete', $pCat->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit" name="status"
                                                                        class="btn btn-danger btn-sm">Full Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $serial++; @endphp
                                        {{-- Sub Category --}}
                                        @foreach (App\Models\Category::orderBy('name', 'asc')->where('is_parent', $pCat->id)->get() as $childCat)
                                            <tr>
                                                <th scope="row">{{ $serial }}</th>
                                                <td>
                                                    @if (is_null($childCat->image))
                                                        <img src="{{ asset('backend/img/categories/Default.png') }}"
                                                            alt="" class="img-fluid rounded-circle table-image">
                                                    @else
                                                        <img src="{{ asset('backend/img/categories/' . $childCat->image) }}"
                                                            class="img-fluid rounded-circle table-image">
                                                    @endif
                                                </td>
                                                <td>{{ $childCat->name }}</td>
                                                <td>
                                                    @if ($childCat->status == 2)
                                                        <span class="badge badge-warning">Soft Deleted</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group action-bar" role="group">
                                                        <a href="" data-toggle="modal"
                                                            data-target="#description-{{ $childCat->id }}"><i
                                                                class="fas fa-eye"></i></a>
                                                        <a href="{{ route('category.edit', $childCat->id) }}"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="" data-toggle="modal"
                                                            data-target="#fulldelete-{{ $childCat->id }}"><i
                                                                class="fas fa-trash"></i></a>
                                                    </div>
                                                    <!-- View Modal -->
                                                    <div class="modal fade effect-scale modal-dark"
                                                        id="description-{{ $childCat->id }}" tabindex="-1"
                                                        aria-labelledby="viewModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm modal-dialog-centered">
                                                            <div class="modal-content bd-0">
                                                                <div class="modal-header pd-x-20">
                                                                    <h5 class="modal-title" id="viewModalLabel">Category
                                                                        Descripton</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body pd-20">
                                                                    <p class="mg-b-5">
                                                                        @if (!$childCat->description)
                                                                            No Description Added
                                                                        @else
                                                                            {!! $childCat->description !!}
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-secondary btn-sm"
                                                                        data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Full Delete Modal -->
                                                    <div class="modal fade effect-scale modal-dark"
                                                        id="fulldelete-{{ $childCat->id }}" tabindex="-1"
                                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm modal-dialog-centered">
                                                            <div class="modal-content bd-0">
                                                                <div class="modal-header pd-x-20">
                                                                    <h5 class="modal-title" id="deleteModalLabel">Full
                                                                        Delete Category</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body pd-20">
                                                                    <p class="mg-b-5">
                                                                        Category Will Be Completely Removed From Database!
                                                                    </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-secondary btn-sm"
                                                                        data-dismiss="modal">Close</button>
                                                                    <form
                                                                        action="{{ route('category.fulldelete', $childCat->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button type="submit" name="fullDelete"
                                                                            class="btn btn-danger btn-sm">Full
                                                                            Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @php $serial++; @endphp
                                        @endforeach
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
