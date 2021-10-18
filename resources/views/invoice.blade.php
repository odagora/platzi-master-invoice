@extends('layout')

@section('content')

<span id="status"></span>

<table class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:40%" class="text-center">Producto</th>
            <th style="width:5%" class="text-center">Cantidad</th>
            <th style="width:15%" class="text-center">Valor Unitario</th>
            <th style="width:20%" class="text-center">SubTotal</th>
            <th style="width:20%" class="text-center">Acción</th>
        </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    @if(session('invoice'))
        @foreach ((array) session('invoice') as $id => $details)
        <?php $total += $details['price'] * $details['quantity'];  ?>

        <tr>
            <td data-th="Producto" class="text-center">{{$details['name']}}</td>
            <td data-th="Cantidad" class="text-center"><input type="number" value="{{$details['quantity']}}" class="form-control quantity"></td>
            <td data-th="Valor Unitario" class="text-center">$<span>{{$details['price']}}</span></td>
            <td data-th="SubTotal" class="text-center">$<span class="product-subtotal">{{$details['price'] * $details['quantity']}}</span></td>
            <td class="text-center">
                <button class="btn btn-primary btn-sm update-invoice" data-id="{{$id}}"><i class="fa fa-refresh"></i></button>
                <button class="btn btn-danger btn-sm remove-from-invoice" data-id="{{$id}}"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="hidden-xs"></td>
            <td class="text-right"><strong>Promo 30%:</strong></td>
            <td class="hidden-xs">
                <input type="text" class="form-control discount">
            </td>
            <td class="text-center">
                <button class="btn btn-success discount-invoice">Aplicar descuento</button>
            </td>
        </tr>
        <tr>
            <td><a href="{{url('/')}}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Seguir comprando</a></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong>Valor Total: $<span class="invoice-total">{{$total}}</span></strong></td>
        </tr>
    </tfoot>
</table>

@endsection

@section('scripts')
    <script type="text/javascript">
        $('.update-invoice').click(function (e) {
            e.preventDefault();

            var ele = $(this);
            var parent_row = ele.parents("tr");
            var quantity = parent_row.find(".quantity").val();
            var product_subtotal = parent_row.find("span.product-subtotal");
            var invoice_total = $(".invoice-total");

            $.ajax({
                url: '{{url('update-invoice')}}',
                method:"PATCH",
                data: {_token: '{{csrf_token()}}', id: ele.attr('data-id'), quantity: quantity},
                dataType: "json",
                success: function (response) {
                    $('span#status').html('<div class="alert alert-success">'+response.msg+'</div>');

                    $('#header-bar').html(response.data);

                    product_subtotal.text(response.subTotal);
                    invoice_total.text(response.total);
                }
            });
        });
        $('.remove-from-invoice').click(function (e) {
            e.preventDefault();

            var ele = $(this);
            var parent_row = ele.parents("tr");
            var invoice_total = $(".invoice-total");

            if(confirm("¿Estas seguro de eliminar el producto?")){
                $.ajax({
                    url: '{{url('remove-from-invoice')}}',
                    method: "DELETE",
                    data: {_token: '{{csrf_token()}}', id: ele.attr('data-id')},
                    dataType: "json",
                    success: function (response) {
                        parent_row.remove();
                        $('span#status').html('<div class="alert alert-success">'+response.msg+'</div>');

                        $('#header-bar').html(response.data);

                        invoice_total.text(response.total);
                    }
                });
            }
        });
        $('.discount-invoice').click(function (e) {
            e.preventDefault();

            var ele = $(this);
            var parent_row = ele.parents("tr");
            var discount = parent_row.find(".discount").val();
            // var product_subtotal = parent_row.find("span.product-subtotal");
            var invoice_total = $(".invoice-total");

            $.ajax({
                url: '{{url('discount-invoice')}}',
                method:"PATCH",
                data: {_token: '{{csrf_token()}}', id: ele.attr('data-id'), discount: discount},
                dataType: "json",
                success: function (response) {
                    $('span#status').html('<div class="alert alert-success">'+response.msg+'</div>');

                    $('#header-bar').html(response.data);

                    invoice_total.text(response.total);
                }
            });
        });
    </script>
@endsection