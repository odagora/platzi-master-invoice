@extends('layout')

@section('content')

<div class="container products">
    <span id="status"></span>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <th><a href="javascript:void(0);" data-id="{{$product->id}}" role="button" class="btn btn-warning btn-block text-center add-to-invoice">Agregar</a></th>
                        <i class="fa fa-circle-o-notch fa-spin btn-loading" style="font-size:24px; display: none"></i>
                    </tr>
                @endforeach
            </tbody>
            {{-- <tfoot>
                <tr>
                    <td><a href="{{url('/invoice')}}" class="btn btn-success">Ver Factura</a></td>
                </tr>
            </tfoot> --}}
        </table>
    </div>
</div>
@endsection

@section('scripts')

    <script type="text/javascript">
        $(".add-to-invoice").click(function (e) {
            e.preventDefault();

            var ele = $(this);

            ele.siblings('.btn-loading').show();

            $.ajax({
                url: '{{ url('add-to-invoice') }}' + '/' + ele.attr("data-id"),
                method: "get",
                data: {_token: '{{ csrf_token() }}'},
                dataType: "json",
                success: function (response) {

                    ele.siblings('.btn-loading').hide();

                    $("span#status").html('<div class="alert alert-success">'+response.msg+'</div>');
                    //$("#header-bar").html(response.data);
                }
            });
        });
    </script>

@stop