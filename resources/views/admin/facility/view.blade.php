@extends('admin.layout.app')
@section('page-title', 'Sub-Facility List')

@section('section')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal"> <i class="fa fa-plus"></i> Create Sub-facility</button>

                                <a href="{{ route('admin.facility.list.all') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-chevron-left"></i> Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">


                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5px">#</th>
                                    <th width="25%">Title</th>
                                    <th width="25%">Description</th>
                                    <th>Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @forelse ($data as $index => $item)
                                <tr class="text-left align-middle">
                                    <td>{{ $index+1}}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->desc }}</td>
                                    <td>
                                        <div class="custom-control custom-switch mt-1" data-toggle="tooltip" title="Toggle status">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$item->id}}" {{ ($item->status == 1) ? 'checked' : '' }} onchange="statusToggle('{{ route('admin.subfacility.status', $item->id) }}')">
                                            <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                                        </div>
                                    </td>
                                    <td class="d-flex text-right">
                                        <div class="btn-group">
                                            <button data-bs-toggle="modal" data-bs-target="#exampleModalEdit{{ $item->id }}" class="btn btn-sm btn-dark" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-danger delete-btn" data-toggle="tooltip" title="Delete" data-id="{{ $item->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                        <!--Edit Sub-Facility Modal -->
                                        <div class="modal fade" id="exampleModalEdit{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Sub Facility</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.subfacility.update') }}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$item->id}}">
                                                            <input type="hidden" name="facility_id" value="{{$id}}">
                                                            <div class="form-group" style="text-align: justify;">
                                                                <label for="title">Title *</label>
                                                                <input type="text" class="form-control" name="SubFacility_title" id="SubFacility_title" placeholder="Enter Title" value="{{$item->title}}" required>
                                                                @error('SubFacility_title') <p class="small text-danger">{{ $message }}</p> @enderror
                                                            </div>
                                                            <div class="form-group" style="text-align: justify;">
                                                                <label for="title">Description *</label>
                                                                <textarea class="form-control" name="SubFacility_description" id="SubFacility_description" placeholder="Enter Description Here" required>{{$item->desc}}</textarea>
                                                                @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button class="btn btn-primary">Upload</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- end modal -->
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="100%" class="text-center">No records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!--Add Sub-Facility Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Sub Facility</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.subfacility.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="facilityId" value="{{$id}}">
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="{{ old('title') }}">
                        @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label for="title">Description *</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Enter Description Here">{{ old('description') }}</textarea>
                        @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- end modal -->




@endsection
@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var itemId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../../subfacility/delete/' + itemId; // Replace '/delete/' with your actual delete route
                }
            });
        });
    });

    // function getSubFacilityInfo(id){
    //     // console.log(id);
    //     $('#id').val(id);
    //     $.ajax({
    //         'type':'post',
    //         'data':{},
    //         'url':"",
    //         'success':function(response,status){
    //             console.log(response);
    //             $('#SubFacility_title').val(response.title);
    //             $('#SubFacility_description').val(response.title);
    //             $('#facility_id').val(response.facility_id);
    //         },
    //         'error':function(error){
    //             if(error) throw error;
    //         }
    //     });
    // }
</script>

@endsection