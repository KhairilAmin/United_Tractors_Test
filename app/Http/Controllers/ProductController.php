<?php

namespace App\Http\Controllers;

use App\Helpers\Format;
use App\Helpers\Storage;
use App\Helpers\Uuid;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function store(Request $request){
        $startTime = microtime(true);
        
        $validate = Validator::make($request->all(),[
            'name' => 'required',
            'product_category_id' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validate->fails()){
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
                [Format::Error => $validate->errors()],
            );

            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $category = CategoryProduct::where('id',$request->product_category_id)->first();

        if (empty($category)) {
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_NOT_FOUND,
                Response::$statusTexts[Response::HTTP_NOT_FOUND],
                [Format::Error => 'Caegory Product ID "' . $request->product_category_id . '" not found'],
            );

            return response()->json($response,Response::HTTP_NOT_FOUND);
        }

        DB::beginTransaction();
        try {
            $product = new Product();
            $product->id = Uuid::getId();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->image = Storage::uploadImage($request->file('image'));
            $product->product_category_id = $category->id;
            $product->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_INTERNAL_SERVER_ERROR,
                Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
                [Format::Error => $e->getMessage()],
            );

            return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_CREATED,
            Response::$statusTexts[Response::HTTP_CREATED],
            [Format::Success => "Successfully create product"],
            $product
        );     
        
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function index(){
        $startTime = microtime(true);
        $product = Product::get();
        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_ACCEPTED,
            Response::$statusTexts[Response::HTTP_ACCEPTED],
            [Format::Success => "Successfully get all product"],
            $product
        );

        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request,$id){
        $startTime = microtime(true);

        $product = Product::where('id',$id)->first();

        if (empty($product)) {
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_NOT_FOUND,
                Response::$statusTexts[Response::HTTP_NOT_FOUND],
                [Format::Error => 'Product ID "' . $id . '" not found'],
            );
            return response()->json($response,Response::HTTP_NOT_FOUND);
        }

        $validate = Validator::make($request->all(),[
            'name' => 'string',
            'product_category_id' => 'string',
            'price' => 'numeric',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validate->fails()){
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_UNPROCESSABLE_ENTITY,
                Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
                [Format::Error => $validate->errors()],
            );

            return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if (!empty($request->product_category_id)) {
            $category = CategoryProduct::where('id',$request->product_category_id)->first();
    
            if (empty($category)) {
                $response = Format::responseData(
                    microtime(true) - $startTime,
                    false,
                    Response::HTTP_NOT_FOUND,
                    Response::$statusTexts[Response::HTTP_NOT_FOUND],
                    [Format::Error => 'Caegory Product ID "' . $request->product_category_id . '" not found'],
                );
    
                return response()->json($response,Response::HTTP_NOT_FOUND);
            }
        }
        if (!empty($request->product_category_id)) {
            $product->product_category_id = $category->id;
        }
        if (!empty($request->name)) {
            $product->name = $request->name;
        }
        if (!empty($request->price)) {
            $product->price = $request->price;
        }
        if (!empty($request->file('image'))) {
            $product->image = Storage::uploadImage($request->file('image'));
        }
        $product->save();

        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK],
            [Format::Success => "Successfully update product"],
            $product
        );     
        
        return response()->json($response, Response::HTTP_OK);
    }

    public function show($id){
        $startTime = microtime(true);

        $product = Product::where('id',$id)->first();

        if (empty($product)) {
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_NOT_FOUND,
                Response::$statusTexts[Response::HTTP_NOT_FOUND],
                [Format::Error => 'Product ID "' . $id . '" not found'],
            );
            return response()->json($response,Response::HTTP_NOT_FOUND);
        }

        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK],
            [Format::Success => "Successfully get Product Category By ID"],
            $product,
        );

        return response()->json($response, Response::HTTP_OK);
    }

    public function delete($id){
        $startTime = microtime(true);
        
        $product = Product::where('id',$id)->first();

        if (empty($product)) {
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_NOT_FOUND,
                Response::$statusTexts[Response::HTTP_NOT_FOUND],
                [Format::Error => 'Product ID "' . $id . '" not found'],
            );
            return response()->json($response,Response::HTTP_NOT_FOUND);
        }

        $product->delete();

        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK],
            [Format::Success => "Successfully delete product    "],
        );

        return response()->json($response, Response::HTTP_OK);
    }
}
