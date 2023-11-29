<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" action="/products/{{$product->id}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label>
            Product name:
            <input name="name" value="{{$product->name}}" />
        </label>
        <label>
            Description:
            <textarea name="description">{{$product->description}}</textarea>
        </label>
        <label>
            Price:
            <input type="number" step="0.01" max="9" name="price" value="{{$product->price}}" />
        </label>
        <label>
            Image:
            <input name="image" type="file" accept="image/*" value="{{$product->imageURL}}" />
        </label>
        <button>Edit</button>
    </form>

</body>

</html>
