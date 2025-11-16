<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\HttpClientException;

class ApiService
{
    // api service untuk dapatkan data diklat pegawai
    public static $client_key = 'SDM_RSUP_SBY';
    public static $secret_key = 'SDM_SECRET_1234!';
    public static $base_url = 'https://diklat.gicbo.com/api/sdm';

    public static function getToken()
    {
        $raw_body = '{
            "client_key": "' . self::$client_key . '",
            "secret": "' . self::$secret_key . '"
        }';


        $response = Http::retry(3, 100)->withBody($raw_body)->post(self::$base_url . '/auth/token');

        if ($response['success'] == false) {
            throw new HttpClientException($response["msg"]);
        }

        return $response->collect('data.token')[0];
    }

    public static function getAllNik($token)
    {
        $response = Http::retry(3, 100)
            ->withToken($token)
            ->post(self::$base_url . '/biodata/all-nik');

        if ($response['success'] == false) {
            throw new HttpClientException($response["msg"]);
        }

        return $response->collect('data');
    }

    public static function getPelatihanByNik($token, $biodata_id)
    {
        $raw_body = '{
            "biodata_id": "' . $biodata_id . '"
        }';

        $response = Http::retry(3, 100)
            ->withToken($token)
            ->withBody($raw_body)
            ->post(self::$base_url . '/biodata/diklat');

        if ($response['success'] == false) {
            throw new HttpClientException($response["msg"]);
        }

        return $response->collect('data');
    }

    public static function getFellowshipByNik($token, $biodata_id)
    {
        $raw_body = '{
            "biodata_id": "' . $biodata_id . '"
        }';

        $response = Http::retry(3, 100)
            ->withToken($token)
            ->withBody($raw_body)
            ->post(self::$base_url . '/biodata/fellowship');

        if ($response['success'] == false) {
            throw new HttpClientException($response["msg"]);
        }

        return $response->collect('data');
    }
}
