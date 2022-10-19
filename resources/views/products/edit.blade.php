<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>edit</title>
</head>
<body>

<form action="{{route('products.update', $product->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <input type="hidden" name="id" value="">
    <p>Name</p>
    <input type="text" name="name" value="{{$product->name}}">
    <p>Amount</p>
    <input type="number" name="amount" value="{{$product->amount}}">
    <p>Price</p>
    <input type="number" name="price" value="{{$product->price}}">
    {{--<p>Picture</p>--}}
    {{--<input type="file" name="productPicture">--}}
    <p>Rate</p>
    <input type="number" name="rate" value="{{$product->rate}}">
    <p>Bought</p>
    <input type="number" name="bought" value="{{$product->bought}}">
    <button type="submit">edit</button>

</form>
</body>
</html>