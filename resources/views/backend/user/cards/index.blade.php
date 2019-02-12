@extends('backend.user.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-left">
                        All Employes
                    </div>
                    <div class="float-right">
                        <a href="{{ route('employe.export') }}" class="h2 text-secondary" title="Download Records as CSV"><i class="fa fa-cloud-download"></i> </a>
                        <a href="{{ route('ids.generate') }}" class="h2 text-success" title="Generate all Cards"><i class="fa fa-file-pdf-o ml-3"></i> </a>
                    </div>
                </div>
                @include('layouts.flash_messages')
                <div class="card-body">
                    <table class="table table-hover table-responsive-md table-striped">
                        <thead>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($employes as $employe)
                                <tr>
                                    <td>
                                        @if ($employe->image)
                                            <img src="{{ route('image.get',[md5(auth()->Id()),$employe->image]) }}" style="height:100px;width:100px;">
                                        @else
                                        @php( $formid = md5(microtime())  )
                                            <form action="{{ route('image.save',$employe->id) }}" enctype="multipart/form-data" id="{{ $formid }}" method="POST">
                                                @csrf
                                                <input type="file" accept="Image/*" name="image" value="Upload Image" onchange="return saveImage('#{{ $formid }}');" placeholder="Upload Image">
                                            </form>
                                        @endif
                                    </td>
                                    <td>{{ $employe->name }}</td>
                                    <td>{{ $employe->email }}</td>
                                    <td>{{ $employe->phone }}</td>
                                    <td>{{ $employe->designation }}</td>
                                    <td>{{ $employe->department }}</td>
                                    <td>
                                        <a href="{{ route('employe.edit',$employe->id) }}" class="h2 text-primary" title="Edit Record"><i class="fa fa-edit"></i> </a>
                                        <a href="#" class="h2 text-danger" onclick="return cdelete('#{{ md5($employe->id) }}')" title="Delete Record"><i class="fa fa-trash"></i> </a>
                                        <a href="{{ route('id.generate',$employe->id) }}" class="h2 text-success" title="View Card"><i class="fa fa-file-pdf-o"></i> </a>
                                        <form method="POST" action="{{ route('employe.destroy',$employe->id) }}" id="{{ md5($employe->id) }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @if (Session::has('alert-success'))
        <script>
            Swal.fire({
                position: 'top-end',
                type: 'success',
                title: '{{ Session::get("alert-success") }}',
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    <script> 
        function saveImage(formId){
            $(formId).submit();
        }
        function cdelete(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    $(id).submit();
                }
            });
        }
    </script>
@endsection
