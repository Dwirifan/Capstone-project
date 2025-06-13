<?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use App\Models\Pembeli;
// use App\Models\Petani;
// use App\Models\Mitra;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
// use Firebase\JWT\JWT;
// class UserController extends Controller
// {
//     //register
//   public function register(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|email|unique:user,email',
//             'password' => 'required|min:6|same:konfirmasi_password',
//             'konfirmasi_password' => 'required|min:6',
//         ]);

//         $Newuser = User::create([
//             'name' => $validated['name'],
//             'google_id' => null,
//             'email' => $validated['email'],
//             'password' => Hash::make($validated['password']),
//             'role' => 'unassigned',
//         ]);
//         return response()->json([
//             'message' => 'User registered successfully',
//             'data' => $Newuser,
//         ], 201);
//     }
//     // login
//    public function login(Request $request)
// {
//     $validated = $request->validate([
//         'email' => 'required|string',
//         'password' => 'required|min:6',
//     ]);

//     $input = $validated['email'];

//     $user = User::where('email', $input)->first();

//     if (!$user) {
//         $petani = Petani::where('username', $input)->first();
//         $pembeli = Pembeli::where('username', $input)->first();
//         $mitra = Mitra::where('username', $input)->first();

//         $roleRecord = $petani ?? $pembeli ?? $mitra;

//         if ($roleRecord) {
//             $user = User::find($roleRecord->id_user);
//         }
//     }

//     if (!$user) {
//         return response()->json(['message' => 'Email atau username tidak ditemukan'], 401);
//     }

//     if (!Hash::check($validated['password'], $user->password)) {
//         return response()->json(['message' => 'Password salah'], 401);
//     }

//     $key = env("JWT_SECRET");
//     $payload = [
//         'id' => $user->id_user,
//         'iat' => time(),
//     ];
//     $hash = "HS256";
//     $token = JWT::encode($payload, $key, $hash);

//     return response()->json([
//         'message' => 'Login berhasil',
//         'token' => $token,
//     ], 200);
// }
// // update profile
// public function updateProfile(Request $request)
// {
//     $userId = $request->id_user;

//     $validated = $request->validate([
//         'role' => 'required|in:petani,pembeli,mitra',
//         'username' => 'required|string|max:255|unique:petani,username,NULL,id_user|unique:pembeli,username,NULL,id_user|unique:mitra,username,NULL,id_user',
//         'tgl_lahir' => 'nullable|date',
//         'no_hp' => 'nullable|string|max:20',
//         'alamat' => 'nullable|string|max:255',
//         'nomor_rekening' => 'nullable|integer',
//     ]);

//     $user = User::find($userId);
//     if (!$user) {
//         return response()->json(['message' => 'User tidak ditemukan'], 404);
//     }

//     $user->role = $validated['role'];
//     $user->save();

//     switch ($validated['role']) {
//         case 'petani':
//             $detail = Petani::updateOrCreate(
//                 ['id_user' => $userId],
//                 [
//                     'username' => $validated['username'],
//                     'tgl_lahir' => $validated['tgl_lahir'],
//                     'no_hp' => $validated['no_hp'],
//                     'alamat' => $validated['alamat'],
//                     'nomor_rekening' => $validated['nomor_rekening'] ?? null,
//                 ]
//             );
//             break;
//         case 'pembeli':
//             $detail = Pembeli::updateOrCreate(
//                 ['id_user' => $userId],
//                 [
//                     'username' => $validated['username'],
//                     'tgl_lahir' => $validated['tgl_lahir'],
//                     'no_hp' => $validated['no_hp'],
//                     'alamat' => $validated['alamat'],
//                 ]
//             );
//             break;
//         case 'mitra':
//             $detail = Mitra::updateOrCreate(
//                 ['id_user' => $userId],
//                 [
//                     'username' => $validated['username'],
//                     'tgl_lahir' => $validated['tgl_lahir'],
//                     'no_hp' => $validated['no_hp'],
//                     'alamat' => $validated['alamat'],
//                     'nomor_rekening' => $validated['nomor_rekening'] ?? null,
//                 ]
//             );
//             break;
//     }

//     return response()->json([
//         'message' => 'Profile berhasil diperbarui',
//         'data' => $detail,
//     ]);
// }

// // reset password 

//     public function profile(request $request){
//         $user = user::where('id_user', $request->id_user)->first();
//         return response ([
//             "massage" => "ini profile", "data"=> $user,
//         ]);
//     }  
// } 
