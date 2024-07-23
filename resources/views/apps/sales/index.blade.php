@extends('apps.layouts.app')

@section('content')
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Sale</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
        </ol>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Sales</h4>
                    <a class="btn btn-primary mb-2" href="javascript:void(0)" id="createNewSale">Create New Sale</a>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration" id="saleTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
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
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="saleForm" name="saleForm" class="form-horizontal">
                    <input type="hidden" name="sale_id" id="sale_id">
                    <div class="form-group">
                        <label for="inventory_id" class="col-sm-2 control-label">Inventory</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="inventory_id" name="inventory_id" required>
                                <option value="">Select Inventory</option>
                                @foreach($inventories as $inventory)
                                    <option value="{{ $inventory->id }}" data-price="{{ $inventory->price }}">{{ $inventory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity" value="" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter Price" value="" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="total" class="col-sm-2 control-label">Total</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="total" name="total" placeholder="Total" value="" readonly>
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
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#saleTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('app.sales.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'quantity', name: 'quantity'},
                {data: 'price', name: 'price'},
                {data: 'total', name: 'total'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#createNewSale').click(function () {
            $('#saveBtn').val("create-sale");
            $('#sale_id').val('');
            $('#saleForm').trigger("reset");
            $('#modelHeading').html("Create New Sale");
            $('#ajaxModel').modal('show');
        });

        $('body').on('click', '.editSale', function () {
            var sale_id = $(this).data('id');
            $.get("{{ route('app.sales.index') }}" +'/' + sale_id +'/edit', function (data) {
                $('#modelHeading').html("Edit Sale");
                $('#saveBtn').val("edit-sale");
                $('#ajaxModel').modal('show');
                $('#sale_id').val(data.id);
                $('#inventory_id').val(data.inventory_id);
                $('#quantity').val(data.quantity);
                $('#price').val(data.price / data.quantity); // Adjust price for edit
                $('#total').val(data.price);
            });
        });

        $('#inventory_id').change(function () {
            var price = $(this).find(':selected').data('price');
            $('#price').val(price);
            var quantity = $('#quantity').val();
            $('#total').val(price * quantity);
        });

        $('#quantity').on('input', function () {
            var price = $('#price').val();
            var quantity = $(this).val();
            $('#total').val(price * quantity);
        });

        $('#saveBtn').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#saleForm').serialize(),
                url: "{{ route('app.sales.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#saleForm').trigger("reset");
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

        $('body').on('click', '.deleteSale', function () {
            var sale_id = $(this).data("id");
            if (confirm("Are You sure want to delete !")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('app.sales.store') }}" + '/' + sale_id,
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
