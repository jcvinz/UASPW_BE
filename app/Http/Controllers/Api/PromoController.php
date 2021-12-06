<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Promo;

class PromoController extends Controller
{
    //
    public function index()
    {
        $promos = Promo::all();

        if(count($promos) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $promos
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id) {
        $promo = Promo::find($id); // mencari data user berdasarkan id

        if(!is_null($promo)) {
            return response([
                'message' => 'Retrieve Promo Success',
                'data' => $promo
            ], 200);
        } // return data user yang ditemukan dalam bentuk json

        return response([
            'message' => 'Promo Not Found',
            'data' => null
        ], 404); // return message saat data user tidak ditemukan
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'namaPromo' => 'required|unique:promos',
            'totalDiskon' => 'required|numeric|between:0,99.99'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);
        
        $promo = Promo::create($storeData);
        return response([
            'message' => 'Add Promo Success',
            'data' => $promo
        ], 200);
    }

    public function destroy($id)
    {
        $promo = Promo::find($id);

        if(is_null($promo)){
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        }

        if($promo->delete()){
            return response([
                'message' => 'Delete Promo Success',
                'data' => $promo
            ], 200);
        }

        return reponse([
            'message' => 'Delete Promo Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        if(is_null($promo)){
            return response([
                'message' => 'Promo Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaPromo' => 'required',
            'totalDiskon' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 404);

        $promo->namaPromo = $updateData['namaPromo'];
        $promo->totalDiskon = $updateData['totalDiskon'];

        if($promo->save()) {
            return response([
                'message' => 'Update Promo Success',
                'data' => $promo
            ], 200);
        }

        return response([
            'message' => 'Update Promo Failed',
            'data' => null,
        ], 400);
    }
}
