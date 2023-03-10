<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- <script src="https://code.jquery.com/jquery-3.6.3.slim.min.js"
        integrity="sha256-ZwqZIVdD3iXNyGHbSYdsmWP//UBokj2FHAxKuSBKDSo=" crossorigin="anonymous"></script> --}}

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="ajaxForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control">
                            <span id="nameError" class="text-danger error-messages"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="">Type</label>
                            <select name="type" class="form-control">
                                <option disabled selected>Choose Option</option>
                                <option value="electronic">Electronic</option>
                                <option value="power">Power</option>
                            </select>
                            <span id="typeError" class="text-danger error-messages"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveBtn"></button>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <div class="row">
        <div class="col-md-6 offset-3" style="margin-top: 100px">
            <a class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Category</a>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#modal-title').html('Create Category');
            $('#saveBtn').html('Save Category');

            // $('#saveBtn').click(function() {
            //     // Go with Id of individual divs
            //     var name = $('#name').val();
            //     var catType = $('#catType').val();
            //     console.log(name);
            //     console.log(catType);
            // })

            var form = $('#ajaxForm')[0];
            $('#saveBtn').click(function() {


                $('.error-messages').html('');

                // Go with name for entire form data
                var formData = new FormData(form);
                // console.log(formData);
                $.ajax({
                    url: '{{ route('categories.store') }}',
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function(response) {
                        console.log(response);
                        if (response.success == 200) {
                            Swal.fire(
                                'Good job !',
                                'Your Data added Successfully !',
                                'success'
                            )
                        }
                    },
                    error: function(error) {
                        if (error) {
                            console.log(error.responseJSON.errors);
                            $('#nameError').html(error.responseJSON.errors.name);
                            $('#typeError').html(error.responseJSON.errors.type);
                        }
                    }
                });


            });


        })
    </script>

</body>

</html>
