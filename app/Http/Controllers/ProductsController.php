<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index() {

        $products = Product::all();
        return view('products', compact('products'));
    }

    public function invoice() {

        //$data = session()->get('invoice');

        return view('invoice');
    }

    public function addToInvoice($id){

        $product = Product::find($id);

        //Check if there is a product
        if(!$product){

            abort(404);
        }

        $invoice = session()->get('invoice');

        //return redirect()->back()->with('success', 'Producto acgregado satisfactoriamente');

         //Check if cart is empty then this is the first product
        if(!$invoice){

            $invoice = [
                $id => [
                    "name" => $product->name,
                    "quantity" => 1,
                    "price" => $product->price
                ]
            ];

            session()->put('invoice', $invoice);

            $htmlCart = view('_header_invoice')->render();

            return response()->json(['msg' => 'Producto agregado satisfactoriamente', 'data' => $htmlCart]);
        }

        //If cart not empty then check if this product exists and increment quantity
        if(isset($invoice[$id])){

            $invoice[$id]['quantity']++;
            session()->put('invoice', $invoice);

            $htmlCart = view('_header_invoice')->render();

            return response()->json(['msg' => 'Producto agregado satisfactoriamente', 'data' => $htmlCart]);
        }

        //If product doesn't exist add it to the invoice with quantity = 1
        $invoice[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price
        ];

        session()->put('invoice', $invoice);

        $htmlCart = view('_header_invoice')->render();

        return response()->json(['msg' => 'Producto agregado satisfactoriamente', 'data' => $htmlCart]);
    }

    public function update(Request $request){

        if($request->id and $request->quantity){

            $invoice = session()->get('invoice');

            $invoice[$request->id]['quantity'] = $request->quantity;

            session()->put('invoice', $invoice);

            $subTotal = $invoice[$request->id]['quantity'] * $invoice[$request->id]['price'];

            $total = $this->getInvoiceTotal();

            $htmlCart = view('_header_invoice')->render();

            return response()->json(['msg' => 'Factura actualizada satisfactoriamente', 'total' => $total, 'subTotal' => $subTotal, 'data' => $htmlCart]);
        }
    }

    public function discount(Request $request){

        if($request->discount){

            $total = $this->getInvoiceTotal();

            if($request->discount == 'promo30'){
                $total *= 0.7;
                $total = number_format($total, 0);
                $htmlCart = view('_header_invoice')->render();
                return response()->json(['msg' => 'Descuento aplicado satisfactoriamente', 'total' => $total, 'data' => $htmlCart,]);
            }
        }
    }

    public function remove(Request $request){

        if($request->id){

            $invoice = session()->get('invoice');

            if(isset($invoice[$request->id])){

                unset($invoice[$request->id]);

                session()->put('invoice', $invoice);
            }

            $total = $this->getInvoiceTotal();

            $htmlCart = view('_header_invoice')->render();

            return response()->json(['msg' => 'Producto eliminado satisfactoriamente', 'data' => $htmlCart, 'total' => $total]);
        }
    }

    /**
     * getInvoiceTotal
     *
     * @return float/int
     */
    private function getInvoiceTotal(){

        $total = 0;

        $invoice = session()->get('invoice');

        foreach($invoice as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return $total;

    }

}
