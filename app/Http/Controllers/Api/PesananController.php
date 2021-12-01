<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Pesanan;

class PesananController extends Controller
{
    //
    public function index() {
        $pesanans = Pesanan::all(); // mengambil semua data user

        if (count($pesanans) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pesanans
            ], 200);
        } // return data semua user dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data user kosong
    }

    // method untuk menampilkan 1 data user (search)
    public function show($id) {
        $pesanan = Pesanan::find($id); // mencari data user berdasarkan id

        if(!is_null($pesanan)) {
            return response([
                'message' => 'Retrieve Pesanan Success',
                'data' => $pesanan
            ], 200);
        } // return data user yang ditemukan dalam bentuk json

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404); // return message saat data user tidak ditemukan
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required|max:60',
            'no_telp' => 'required|regex:/(08)[0-9]/|max:13',
            'alamat' => 'required',
            'paket' => 'required',
            'harga' => 'required|numeric',
            'promo' => 'nullable',
            'status' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pesanan = Pesanan::create($storeData);
        return response([
            'message' => 'Add Pesanan Success',
            'data' => $pesanan
        ], 200);   
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::find($id);

        if(is_null($pesanan)){
            return response([
                'message' => 'Pesanan Not Found',
                'data' => null
            ], 404);
        }

        if($pesanan->delete()){
            return response([
                'message' => 'Delete Pesanan Success',
                'data' => $pesanan
            ], 200);
        }

        return response([
            'message' => 'Delete Pesanan Failed',
            'data' => null,
        ], 400);
    }

    public function update_status(Request $request, $id)
    {
        $pesanan = Pesanan::find($id);
        if(is_null($pesanan)){
            return response([
                'message' => 'Pesanan Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama' => 'required|max:60',
            'no_telp' => 'required|regex:/(08)[0-9]/|max:13',
            'alamat' => 'required',
            'paket' => 'required',
            'harga' => 'required|numeric',
            'promo' => 'nullable',
            'status' => 'required|numeric'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $pesanan->status = $updateData['status'];

        if($pesanan->save()){
            return response([
                'message' => 'Update Status Pesanan Success',
                'data' => $course
            ], 200);

        }

        return response([
            'message' => 'Update Status Pesanan Failed',
            'data' => null,
        ], 400);
    }
}
