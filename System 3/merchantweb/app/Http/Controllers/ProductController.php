<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index(Request $request){
        return view('index', [
            'products' => Product::latest()->get()
        ]);
    }

    public function otp(Product $product){
        return view('otp', [
            'product' => $product
        ]);
    }

    public function buy(Product $product){
        $response = Http::post('http://localhost:8080/atm2/DeductMoneyServlet?acc-num=' . auth()->user()->accnum . '&amount=' . strval($product->price));

        if (str_contains($response, 'INVALID') || str_contains($response, 'FAIL')){
            // dd("fail: ".$response);
            return view('result', [
                'result' => FALSE
            ]);
        } else {
            // dd("success: ".$response);
            return view('result', [
                'result' => TRUE
            ]);
        }
    }

    // public function success(){
    //     return view('result', [
    //         'result' => TRUE
    //     ]);
    // }

    // public function fail(){
    //     return view('result', [
    //         'result' => FALSE
    //     ]);
    // }
}
