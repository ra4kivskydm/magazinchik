<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>


@if (Route::has('login'))
    <div class="hidden absolute top-0 right-0 px-6 py-4 sm:block ">
        @auth
            @include ('layouts.navigation')
        @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
        @endif
    </div>
@endif
<br>
<table class="min-w-full mt-12 border-collapse block md:table">
    <thead class="block md:table-header-group">
    <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
        <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
            Name
        </th>
        <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
            Amount
        </th>
        <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
            Price
        </th>
        <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
            Rating
        </th>
        <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
            Bought
        </th>
            <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                Actions
            </th>
    </tr>
    </thead>

    @foreach($products as $product)
        <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                        class="inline-block w-1/3 md:hidden font-bold">Name</span><a class="text-blue-600"
                                                                                     href="{{route('products.show', $product->id)}}">{{$product->name}}</a>
            </td>
            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                        class="inline-block w-1/3 md:hidden font-bold">User Name</span>{{$product->amount}}</td>
            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                        class="inline-block w-1/3 md:hidden font-bold">Email Address</span>{{$product->price}}</td>
            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                        class="inline-block w-1/3 md:hidden font-bold">Mobile</span>{{$product->rate}}</td>
            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                        class="inline-block w-1/3 md:hidden font-bold">Mobile</span>{{$product->bought}}</td>

                <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                    @if (auth()->check())
                    <span class="inline-block w-1/3 md:hidden font-bold">Actions</span>

                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">
                        <a href="{{route('products.edit', $product->id)}}">Edit</a></button>
                    <form action="{{route('products.destroy', $product->id)}}" method="post" id="delete_prod">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">
                            Delete
                        </button>
                    </form>
                    @endif
                    <form action="{{route('products.buy', $product->id)}}" method="post" id="buy_prod">
                        @csrf

                        <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 border border-yellow-500 rounded">
                            Buy
                        </button>
                    </form>

                </td>

        </tr>


        {{--<td><a href="buy.php?id=&bought=">Buy</a></td>--}}
    @endforeach


</table>
@if (auth()->check())
    <form action="{{ route('products.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <p>Name</p>
        <input type="text" name="name">
        <p>Amount</p>
        <input type="number" name="amount">
        <p>Price</p>
        <input type="number" name="price">
        <p>Picture</p>
        <input type="file" name="productPicture">
        <p>Rate</p>
        <input type="number" name="rate" value="0">
        <p>Bought</p>
        <input type="number" name="bought" value="0">
        <button type="submit">add</button>
    </form>
@endif
</body>
</html>
