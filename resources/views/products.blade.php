@extends('layout')

@section('content')

<div class="container products">
    <span id="status"></span>

    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th class="text-center" style="width:10%">ID</th>
                <th class="text-center" style="width:50%">Nombre</th>
                <th class="text-center" style="width:30%">Precio</th>
                <th class="text-center" style="width:10%">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td class="text-center" style="width:10%">{{$product->id}}</td>
                    <td class="text-center" style="width:50%">{{$product->name}}</td>
                    <td class="text-center" style="width:30%">$ <span>{{$product->price}}</span></td>
                    <th class="text-center" style="width:10%"><a href="javascript:void(0);" data-id="{{$product->id}}" role="button" class="btn btn-warning btn-block text-center add-to-invoice">Agregar</a><i class="fa fa-circle-o-notch fa-spin btn-loading" style="font-size:24px; display: none"></i></th>
                </tr>
            @endforeach
        </tbody>
    </table>
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
                    $("#header-bar").html(response.data);
                }
            });
        });
    </script>

@stop