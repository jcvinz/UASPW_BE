<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $registrationData = $request->all();
        $validate = Validator::make($registrationData, [
            'name' => 'required|max:60',
            'no_telp' => 'required|regex:/(08)[0-9]/|max:13',
            'alamat' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required'
        ]);

    if($validate->fails())
        return response(['message' => $validate->errors()], 400);

    $temp = $registrationData['password'];
    $registrationData['password'] = bcrypt($request->password);
    $user = User::create($registrationData);

    try{
        $date = Carbon::now();
        $detail = [
            'email' => $registrationData['email'],
            'password' => $temp,
            'date' => $date,
        ];
        Mail::to($registrationData['email'])->send(new UserMail($detail));
        return response([
            'message' => 'Register Success and email send successfully',
            'user' => $user
        ], 200);
    } catch(Exception $e) {
        return response([
                'message' => 'Register Success but cannot send the email',
                'user' => $user
            ], 200);
        }
    }

    public function login(Request $request) {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        if (!Auth::attempt($loginData))
            return response(['message' => 'Invalid Credentials'], 401);
        
        $user = Auth::user();
        $token = $user->createToken('Authentication Token')->accessToken;

        return response([
            'message' => 'Authenticated',
            'user' => $user,
            'token_type' => 'Bearer',
            'access_token' => $token
        ]);
    }

    public function update_date(Request $request, $id) {
        $user = User::find($id);
        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'date' => 'required|date',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $user->email_verified_at = $updateData['date'];

        if ($user->save()) {
            return response([
                'message' => 'Verification Email Success',
                'data' => $user
            ], 200);
        } // return data user baru dalam bentuk json

        return response([
            'message' => 'Verification Email Failed',
            'data' => null
        ], 400); // return message saat user gagal di edit
    }

    public function index() {
        $users = User::all(); // mengambil semua data user

        if (count($users) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $users
            ], 200);
        } // return data semua user dalam bentuk json

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data user kosong
    }

    // method untuk menampilkan 1 data user (search)
    public function show($id) {
        $user = User::find($id); // mencari data user berdasarkan id

        if(!is_null($user)) {
            return response([
                'message' => 'Retrieve User Success',
                'data' => $user
            ], 200);
        } // return data user yang ditemukan dalam bentuk json

        return response([
            'message' => 'User Not Found',
            'data' => null
        ], 404); // return message saat data user tidak ditemukan
    }

    // method untuk menghapus 1 data product (delete)
    public function destroy($id) {
        $user = User::find($id); // mencari data user berdasarkan id

        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        } // return message saat data user tidak ditemukan

        if ($user->delete()) {
            return response([
                'message' => 'Delete User Success',
                'data' => $user
            ], 200);
        } // return message saat berhasil menghapus data user
        
        return response([
            'message' => 'Delete User Failed',
            'data' => null,
        ], 400); // return message saat gagal menghapus data user
    }

    //method untuk mengubah 1 data user (update)
    public function update(Request $request, $id) {
        $user = User::find($id); // mencari data user berdasarkan id
        if (is_null($user)) {
            return response([
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        } // return message saat data user tidak ditemukan

        $updateData = $request->all(); // mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'nama' => 'required|max:60',
            'no_telp' => 'required|regex:/(08)[0-9]/|max:13',
            'alamat' => 'required',
            'email' => ['email:rfc,dns', 'required', Rule::unique('users')->ignore($user)],
            'password' => 'required'
        ]); // membuat rule validasi input

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $user->name = $updateData['name']; // edit name
        $user->no_telp = $updateData['no_telp'];
        $user->alamat = $updateData['alamat'];
        $user->email = $updateData['email']; // edit email
        $user->password = bcrypt($updateData['password']);

        if ($user->save()) {
            return response([
                'message' => 'Update User Success',
                'data' => $user
            ], 200);
        } // return data user baru dalam bentuk json

        return response([
            'message' => 'Update User Failed',
            'data' => null
        ], 400); // return message saat user gagal di edit
    }

    public function logout() {
        $user = Auth::user()->token();
        $user->revoke();
        return response([
            'message' => 'Logout Success',
            'user' => $user,
        ]);
    }
}
