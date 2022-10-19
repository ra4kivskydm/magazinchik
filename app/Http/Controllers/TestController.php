<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function action()
    {
        Product::query()->create([
            'name' =>'tomato',
            'amount' => 2,
            'price' => 3,
            'rate' => 4,
            'bought' => 5,
            'place' => 'avc']);
        return view('test');
    }
    public function getProduct(Product $supproduct)
    {
        return view('product', compact('supproduct'));
    }

    public function getSomeProduct($id)
    {
        $product = Product::query()->find($id);
        return view('product', ['supproduct' => $product]);
    }
    public function getProductByQB($id)
    {
        $object = new \stdClass();
        $object->testproperty = 'hhj';
        $product = DB::table('products')
            ->where('id', '=', $id)
            ->select(['id','name'])
            ->first();
        return view('product', ['supproduct' => $product, 'testObject' => $object]);
    }
}
