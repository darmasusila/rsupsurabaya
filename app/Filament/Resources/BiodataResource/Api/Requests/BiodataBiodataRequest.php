<?php

namespace App\Filament\Resources\BiodataResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BiodataBiodataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'nama' => 'required',
			'gelar_depan' => 'required',
			'gelar_belakang' => 'required',
			'nik' => 'required',
			'tempat_lahir' => 'required',
			'tanggal_lahir' => 'required|date',
			'jenis_kelamin' => 'required',
			'alamat' => 'required',
			'telepon' => 'required',
			'email' => 'required',
			'agama' => 'required',
			'golongan_darah' => 'required',
			'status_perkawinan' => 'required',
			'nokk' => 'required'
		];
    }
}
