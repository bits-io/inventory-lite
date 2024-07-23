@extends('apps.layouts.app')

@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Inventory</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
        </ol>
    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Inventory</h4>
                    <a class="btn btn-primary mb-2" href="#" id="createNewInventory">Create New Inventory</a>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration" id="inventoryTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create and Edit Modal -->
<div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog" aria-labelledby="ajaxModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="inventoryForm" name="inventoryForm" class="form-horizontal">
                    <input type="hidden" name="inventory_id" id="inventory_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" value="" min="0" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stock" class="col-sm-2 control-label">Stock</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Enter Stock" value="" min="0" required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#inventoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('app.inventory.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'price', name: 'price'},
                {data: 'stock', name: 'stock'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewInventory').click(function () {
            $('#saveBtn').val("create-inventory");
            $('#inventory_id').val('');
            $('#inventoryForm').trigger("reset");
            $('#modelHeading').html("Create New Inventory");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editInventory', function () {
            var inventory_id = $(this).data('id');
            $.get("{{ route('app.inventory.index') }}" +'/' + inventory_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Inventory");
                $('#saveBtn').val("edit-inventory");
                $('#ajaxModel').modal('show');
                $('#inventory_id').val(data.id);
                $('#name').val(data.name);
                $('#price').val(data.price);
                $('#stock').val(data.stock);
            })
        });

        $('#inventoryForm').on('submit', function (e) {
            e.preventDefault();

            // Ambil nilai input
            var price = parseFloat($('#price').val());
            var stock = parseInt($('#stock').val());

            // Validasi di sisi klien
            if (isNaN(price) || price < 0) {
                alert('Price must be a non-negative number.');
                return;
            }

            if (isNaN(stock) || stock < 0) {
                alert('Stock must be a non-negative integer.');
                return;
            }

            $('#saveBtn').html('Sending..');

            $.ajax({
                data: $(this).serialize(),
                url: "{{ route('app.inventory.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#inventoryForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    $('#saveBtn').html('Save changes');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#saveBtn').html('Save changes');
                }
            });
        });


        $('body').on('click', '.deleteInventory', function () {
            var inventory_id = $(this).data("id");
            if(confirm("Are You sure want to delete !")){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('app.inventory.store') }}"+'/'+inventory_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });

    });
</script>
@endpush
