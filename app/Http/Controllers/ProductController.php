<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    use HttpResponses;

    public function newArrival(Request $request){
        $products=Product::latest()->take(8)->get();
        return $this->response($products);
    }
    public function randomformen(Request $request){
        $products=Product::where('genre', 'men')->inRandomOrder()->take(4)->get();
        return $this->response($products);
    }
    public function randomforwomen(Request $request){
        $products=Product::where('genre', 'women')->inRandomOrder()->take(4)->get();
        return $this->response($products);
    }
    public function alsolike(Request $request){
        $products=Product::inRandomOrder()->take(4)->get();
        return $this->response($products);
    }
    public function productsmen(Request $request){
        $products=Product::Where('genre','men')->paginate(16);
        return $this->response($products);
    }
    public function productswomen(Request $request){
        $products=Product::Where('genre','women')->paginate(16);
        return $this->response($products);
    }
    public function productskids(Request $request){
        $products=Product::Where('genre','kids')->paginate(16);
        return $this->response($products);
    }
    public function shopall(Request $request){
        $products=Product::paginate(16);
        return $this->response($products);
    }
    public function search(Request $request){
        $searchTerm=$request->term;
        $results = Product::where('name', 'like', "%$request->term%")
        ->orWhereHas('ultraProduct', function ($query) use ($searchTerm) {
            $query->where('description', 'like', "%$searchTerm%");
        })->paginate(16);
        return $this->response($results);
    }
    public function searchcount($term){
        $results = Product::where('name', 'like', "%$term%")
        ->orWhereHas('ultraProduct', function ($query) use ($term) {
            $query->where('description', 'like', "%$term%");
        })->count();
        return $this->response($results);
    }
    public function suggBag() {
        $products=Product::inRandomOrder()->take(3)->get();
        return $this->response($products);
    }
    public function product($token){
        $product=Product::where('token',$token)->first();
        $product->UltraProduct;
        $product=new ProductResource($product);
        return $this->response($product);
    }
}
