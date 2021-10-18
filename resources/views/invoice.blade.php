@extends('layout')

@section('content')

<span id="status"></span>

<table class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:5%" class="text-center">Cantidad</th>
            <th style="width:45%" class="text-center">Producto</th>
            <th style="width:15%" class="text-center">Valor Unitario</th>
            <th style="width:15%" class="text-center">Valor Total</th>
            <th style="width:20%" class="text-center">Acción</th>
        </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    @if(session('invoice'))
        @foreach ((array) session('invoice') as $id => $details)
        <?php $total += $details['price'] * $details['quantity'];  ?>

        <tr>
            <td data-th="Cantidad" class="text-center">{{$details['quantity']}}</td>
            <td data-th="Producto" class="text-center">{{$details['name']}}</td>
            <td data-th="Valor Unitario" class="text-center">{{$details['price']}}</td>
            <td data-th="Valor Total" class="text-center">{{$details['price'] * $details['quantity']}}</td>
            <td class="text-center">
                <button class="btn btn-danger btn-sm remove-from-invoice" data-id="{{$id}}"><i class="fa fa-trash-o"></i></button>
            </td>
        </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
        <tr>
            <td><a href="{{url('/')}}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Seguir comprando</a></td>
            <td colspan="2" class="hidden-xs"></td>
            <td class="hidden-xs text-center"><strong>Total $<span class="invoice-total">{{$total}}</span></strong></td>
        </tr>
    </tfoot>
</table>

@endsection

@section('scripts')
    <script type="text/javascript">
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
                        invoice_total.text(response.total);
                    }
                });
            }
        });
    </script>
@endsection