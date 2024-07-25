<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Validator;

class GenreController extends Controller
{
    public function index()
    {
        $genre = Genre::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data Genre',
            'data'=> $genre,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        // vaidate data
        $validator = Validator::make($request->all(),[
            'nama_genre' => 'required|unique:genres',
        ], [
            'nama_genre.required' => 'Masukan genre',
            'nama_genre.unique' => 'Genre Sudah digunakan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = new Genre;
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
        }

        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan',
            ], 400);
        }
    }

    public function show($id)
    {
        $genre = Genre::find($id);

        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Detail genre',
                'data' => $genre,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Genre Tidak ditemukan',
                'data' => '',
            ], 404);
        }
    }

    public function update(Request $request,$id)
    {
        // vaidate data
        $validator = Validator::make($request->all(),[
            'nama_genre' => 'required|unique:genres',
        ], [
            'nama_genre.required' => 'Masukan genre',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = Genre::find($id);
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
        }

        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan',
            ], 400);
        }
    }

    public function destroy($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $genre->delete();
            return response()->json([
                'success'=> true,
                'message' => 'Data ' . $genre->nama_ketegori . 'berhasil dihapus',
        ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }
}
