<!DOCTYPE html>
<html>
<head>
    <title>Laravel Ajax Form Demo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <style>
        form.form-inline {
            border: 1px solid;
            padding: 30px 0px 45px 0px;
            background-color: #9d9af2;
        }
        .dataTables_wrapper {
            padding: 19px;
        }
        .card-body {
            background-color: #edeef5;
        }
        span.error {
            color: #ab0a0a;
            display: block;
            margin-top: 0px;
            margin-bottom:0px;
            width: 100%;
            float: left;
        }
    </style>
</head>
<body>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                    
                        <div class="table-responsive">
                        <h4 class="card-title">Users List</h4>
                        <form id="userForm" class="form-inline" enctype="multipart/form-data">
                        @csrf
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="naem">Name:</label>
                                    <input type="text" class="form-control" name="name" placeholder="Name">      
                                </div>
                                <span id="name" class="error"></span>                      
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="text" name="email" class="form-control" placeholder="Email">
                                </div>
                                <span id="email" class="error"></span>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="phone">Phone No.:</label>                                
                                    <input type="text" name="phone" placeholder="Phone" class="form-control">
                                </div>
                                <span id="phone" class="error"></span>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea name="description" placeholder="Description" class="form-control"></textarea>
                                </div>
                                <span id="description" class="error"></span>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="role">Role:</label>
                                    <select name="role_id" class="form-control">
                                        <option value="">Select</option>
                                        @foreach($roles as $val)
                                            <option value="{{ $val->id }}">{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span id="role_id" class="error"></span>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="file">Profile Image:</label>
                                    <input type="file" name="profile_image" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                        

                            <table class="table table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Description</th>
                                        <th>Role</th>
                                        <th>Profile Image</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.data') }}",
                    type: 'POST',
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'description', name: 'description' },
                    { data: 'role_id', name: 'role_id', orderable: false, searchable: false },
                    { data: 'profile_image', name: 'profile_image', orderable: false, searchable: false,
                      render: function(data, type, full, meta) {
                          return data ? `<img src="{{ url('images') }}/${data}" height="50"/>` : '';
                      }
                    }
                ]
            });

            $('#userForm').on('submit', function(event) {
                event.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('user.store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        table.ajax.reload();
                        alert(data.success);
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        console.log('errors',errors)
                        for (let key in errors) {
                            $('#'+key).text(errors[key]);
                        }
                    }
                });
            });
        });
        
    </script>
</body>
</html>
