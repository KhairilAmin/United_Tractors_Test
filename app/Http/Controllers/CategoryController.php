<?php

namespace App\Http\Controllers;

use App\Helpers\Format;
use App\Helpers\Uuid;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function store(Request $request){
        $startTime = microtime(true);
        
        $validate = Validator::make($request->all(),[
            'name' => 'required'
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

        DB::beginTransaction();
        try {
            $category = new CategoryProduct;
            $category->id = Uuid::getId();
            $category->name = $request->name;
            $category->save();
            // dd($category->id);   
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
            [Format::Success => "Successfully create product category"],
            $category
        );     
        
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function index(){
        $startTime = microtime(true);
        
        $categories = CategoryProduct::get();
        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_ACCEPTED,
            Response::$statusTexts[Response::HTTP_ACCEPTED],
            [Format::Success => "Successfully get all product category"],
            $categories
        );
        
        return response()->json($response, Response::HTTP_CREATED);
    }

    public function update(Request $request,$id){
        $startTime = microtime(true);
        
        $category = CategoryProduct::where('id',$id)->first();

        if (empty($category)) {
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_NOT_FOUND,
                Response::$statusTexts[Response::HTTP_NOT_FOUND],
                [Format::Error => 'Product Category ID "' . $id . '" not found'],
            );
            return response()->json($response,Response::HTTP_NOT_FOUND);
        }

        $validate = Validator::make($request->all(),[
            'name' => [
                'required',
                Rule::unique('category_product')->ignore($category->id),
            ],
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

        $category->name = $request->name;
        $category->save();

        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK],
            [Format::Success => "Successfully update Product Category"],
            $category,
        );

        return response()->json($response, Response::HTTP_OK);

    }

    public function show($id){
        $startTime = microtime(true);
        
        $category = CategoryProduct::where('id',$id)->first();

        if (empty($category)) {
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_NOT_FOUND,
                Response::$statusTexts[Response::HTTP_NOT_FOUND],
                [Format::Error => 'Product Category ID "' . $id . '" not found'],
            );
            return response()->json($response,Response::HTTP_NOT_FOUND);
        }
        
        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK],
            [Format::Success => "Successfully get Product Category By ID"],
            $category,
        );

        return response()->json($response, Response::HTTP_OK);
    }

    public function delete($id){
        $startTime = microtime(true);
        
        $category = CategoryProduct::where('id',$id)->first();

        if (empty($category)) {
            $response = Format::responseData(
                microtime(true) - $startTime,
                false,
                Response::HTTP_NOT_FOUND,
                Response::$statusTexts[Response::HTTP_NOT_FOUND],
                [Format::Error => 'Product Category ID "' . $id . '" not found'],
            );
            return response()->json($response,Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        $response = Format::responseData(
            microtime(true) - $startTime,
            true,
            Response::HTTP_OK,
            Response::$statusTexts[Response::HTTP_OK],
            [Format::Success => "Successfully delete product category"],
        );

        return response()->json($response, Response::HTTP_OK);

    }
}
