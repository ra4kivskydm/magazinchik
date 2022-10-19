<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show', 'buy']);
    }
    public function index()
    {
        $products = Product::all();
        return view('products/index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('productPicture')) {
            $image = $request->file('productPicture');
            $path = $image->store('products');
            $request->merge(['place' => $path]);

        }

        Product::query()->create($request->all());
        return redirect('products');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd(asset('storagegi'));

        $comments = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.id', 'users.name', 'comments.comment', 'comments.user_id')
            ->get();

        //$comments = Comment::all()->where('product_id','=', $id);
        $user_id = Auth::id();

        $product = Product::query()->findOrFail($id);
        return view('products/product', compact('product', 'comments', 'user_id'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::query()->find($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::query()->findOrFail($id);
        $input = $request->all();
        $product->fill($input)->save();
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::query()->findOrFail($id);
        if ($product->place === '' || $product->place !== null) {
            $path = $product->place;
            if (Storage::exists('/storage/'. $path)) {
                unlink((public_path('/storage/'. $path)));
            }

        }


        $product->delete();
        return redirect('products');
    }

    public function buy($id)
    {
        $product = Product::query()->findOrFail($id);
        if ($product->amount <= 0) {
            return back();
        }
        $product->amount -= 1;
        $product->bought += 1;
        $product->save();
        return back();
    }
}
