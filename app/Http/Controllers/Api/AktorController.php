<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aktor;
use Illuminate\Http\Request;
use Validator;

class AktorController extends Controller
{
    public function index()
    {
        $aktor = Aktor::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Data Aktor',
            'data'=> $aktor,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        // vaidate data
        $validator = Validator::make($request->all(),[
            'nama_aktor' => 'required|unique:aktors',
            'biodata' => 'required',
        ], [
            'nama_aktor.required' => 'Masukan Nama Aktor',
            'nama_aktor.unique' => 'Nama Aktor Sudah Tersedia',
            'biodata.required' => 'Masukan Biodata Aktor',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = new Aktor;
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }

        if ($aktor) {
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
        $aktor = Aktor::find($id);

        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Aktor',
                'data' => $aktor,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Aktor Tidak ditemukan',
                'data' => '',
            ], 404);
        }
    }

    public function update(Request $request,$id)
    {
        // vaidate data
        $validator = Validator::make($request->all(),[
            'nama_aktor' => 'required',
            'biodata' => 'required',
        ], [
            'nama_aktor.required' => 'Masukan Nama Aktor',
            'biodata.required' => 'Masukan Biodata Aktor',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = Aktor::find($id);
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->biodata = $request->biodata;
            $aktor->save();
        }

        if ($aktor) {
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
        $aktor = Aktor::find($id);
        if ($aktor) {
            $aktor->delete();
            return response()->json([
                'success'=> true,
                'message' => 'Data ' . $aktor->nama_ketegori . 'berhasil dihapus',
        ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }
}
