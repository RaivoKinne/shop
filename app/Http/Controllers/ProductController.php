<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view("products.index", ["products" => $products]);
    }

    public function create()
    {
        return view("products.create");
    }

    public function store(Request $request, Product $product)
    {
        $request->validate(
            [
                "name" => ["required", "min:5", "max:50"],
                "description" => ["required", "min:5", "max:255"],
                "price" => ["required", "numeric"],
                "image" => ["required", "image", "max:10240"]
            ]
        );
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        $image = $request->file('image'); // storing img to variable

        // creating filename and saving the image
        $fileName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $fileName);

        // storing filename to the database
        $product->imageURL = '/images/' . $fileName;

        $product->save();

        return redirect("/products");
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect("/products");
        }

        return view('products.show', ["product" => $product]);
    }

    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect("/products");
        }

        return view('products.edit', ["product" => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => ["required", "min:5", "max:50"],
            "description" => ["required", "min:5", "max:255"],
            "price" => ["required", "numeric"],
            "imageURL" => ["required", "image", "max:10240"]
        ]);

        $product = Product::find($id);

        if ($product) {
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->imageURL = $request->imageURL;
            $product->save();
            return redirect("/products");
        }

        return back()->withInput()->withErrors(['message' => 'No changes detected or product not found']);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
        }

        return redirect("/products");
    }
}
