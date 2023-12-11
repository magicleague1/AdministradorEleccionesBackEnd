<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class juradoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'FECHA_ASIGNACION' => new Carbon('yyyy-MM-dd')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            "CARGO_JURADO"=>'required|min:2|max:30'
        ];
    }

    public function messages(){
        return [
            "CARGO_JURADO.required"=>"El cargo del jurado es obligatorio.",
            'CARGO_JURADO.min' => 'El cargo del jurado debe tener al menos :min caracteres.',
            'CARGO_JURADO.max' => 'El cargo del jurado no puede tener más de :max caracteres.',
        ];
    }
}
