{{-- @extends('layouts/app') --}}

<div class="container"></div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>