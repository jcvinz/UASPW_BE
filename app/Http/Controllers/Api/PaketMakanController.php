<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\PaketMakan;

class PaketMakanController extends Controller
{
    //
    public function index()
    {
        $paketMakans = PaketMakan::all();

        if(count($paketMakans) > 0){
            return response([
                'message' => 'Retrive All Success',
                'data' => $paketMakans
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }


    public function show($id)
    {
        $paketMakan = PaketMakan::find($id);

        if(!is_null($paketMakan)){
            return response([
                'message' => 'Retrieve Paket Makan Success',
                'data' => $paketMakan
            ], 200);
        }

        return response([
            'message' => 'Paket Makan Not Found',
            'data' => null
        ], 404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'namaPaket' => 'required|unique:paket_makans',
            'hargaPaket' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $paketMakan = PaketMakan::create($storeData);
        return response([
            'message' => 'Add Paket Makan Success',
            'data' => $paketMakan
        ], 200); 
    }

    public function destroy($id)
    {
        $paketMakan = PaketMakan::find($id);

        if(is_null($paketMakan)){
            return response([
                'message' => 'Paket Makan Not Found',
                'data' => null
            ], 404);
        }

        if($paketMakan->delete()){
            return response([
                'message' => 'Delete Paket Makan Success',
                'data' => $paketMakan
            ], 200);
        }

        return reponse([
            'message' => 'Delete Paket Makan Failed',
            'data' => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {
        $paketMakan = PaketMakan::find($id);
        if(is_null($paketMakan)) {
            return response([
                'message' => 'Paket Makan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaPaket' => ['required', Rule::unique('paket_makans')->ignore($paketMakan)],
            'hargaPaket' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => validate->errors()], 400);
        
        $paketMakan->namaPaket = $updateData['namaPaket'];
        $paketMakan->hargaPaket = $updateData['hargaPaket'];

        if($paketMakan->save()) {
            return response([
                'message' => 'Update Paket Makan Success',
                'data' => $paketMakan
            ], 200);
        }
        return response([
            'message' => 'Update Paket Makan Failed',
            'data' => null,
        ], 400);
    }
}
