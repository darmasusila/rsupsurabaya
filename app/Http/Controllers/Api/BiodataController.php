<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BiodataController extends Controller
{


    public static function getAllNIK(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return response()->json([
                'status' => '0',
                'message' => 'Email is required'
            ], 400);
        }

        if ($email != 'jabb.kemenkes@gmail.com') {
            return response()->json([
                'status' => '0',
                'message' => 'Unauthorized'
            ], 401);
        }

        $biodata = \App\Models\Biodata::all();
        foreach ($biodata as $item) {
            $pegawai = \App\Models\Pegawai::where('biodata_id', $item->id)->first();
            if (!$pegawai) {
                continue;
            }
            $niks[] = [
                'biodata_id' => $item->id,
                'nik' => $item->nik,
                'nama' => $item->nama,
                'is_active' => $pegawai->is_active
            ];
        }
        $niks = collect($niks);
        if ($niks->isEmpty()) {
            return response()->json([
                'status' => '0',
                'message' => 'No NIKs found'
            ], 404);
        }
        return response()->json([
            'status' => '1',
            'data' => $niks
        ], 200);
    }

    public static function getBiodataByNIK(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return response()->json([
                'status' => '0',
                'message' => 'Email is required'
            ], 400);
        }

        if ($email != 'jabb.kemenkes@gmail.com') {
            return response()->json([
                'status' => '0',
                'message' => 'Unauthorized'
            ], 401);
        }

        $nik = $request->input('nik');
        $biodata = \App\Models\Biodata::where('nik', $nik)->first();
        if (!$biodata) {
            return response()->json([
                'status' => '0',
                'message' => 'Biodata not found'
            ], 404);
        }
        return response()->json([
            'status' => '1',
            'data' => $biodata
        ], 200);
    }

    public static function getPegawaiByNIK(Request $request)
    {
        $email = $request->input('email');
        if (!$email) {
            return response()->json([
                'status' => '0',
                'message' => 'Email is required'
            ], 400);
        }

        if ($email != 'jabb.kemenkes@gmail.com') {
            return response()->json([
                'status' => '0',
                'message' => 'Unauthorized'
            ], 401);
        }

        $nik = $request->input('nik');
        $biodata = \App\Models\Biodata::where('nik', $nik)->first();
        if (!$biodata) {
            return response()->json([
                'status' => '0',
                'message' => 'Biodata not found'
            ], 404);
        }


        $pegawai = \App\Models\Pegawai::where('biodata_id', $biodata->id)
            ->leftjoin('struktural', 'pegawai.struktural_id', '=', 'struktural.id')
            ->leftjoin('departemen', 'pegawai.departemen_id', '=', 'departemen.id')
            ->leftjoin('fungsional', 'pegawai.fungsional_id', '=', 'fungsional.id')
            ->leftjoin('unit', 'pegawai.unit_id', '=', 'unit.id')
            ->leftjoin('jenis_tenaga', 'pegawai.jenis_tenaga_id', '=', 'jenis_tenaga.id')
            ->leftjoin('direktorat', 'pegawai.direktorat_id', '=', 'direktorat.id')
            ->select('pegawai.*', 'struktural.nama as nama_struktural', 'departemen.nama as nama_departemen', 'fungsional.nama as nama_fungsional', 'unit.nama as nama_unit', 'jenis_tenaga.nama as nama_jenis_tenaga')
            ->first();
        if (!$pegawai) {
            return response()->json([
                'status' => '0',
                'message' => 'Pegawai not found'
            ], 404);
        }
        return response()->json([
            'status' => '1',
            'data' => $pegawai
        ], 200);
    }
}
