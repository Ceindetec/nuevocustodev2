<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuncionariosActualizarRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre'=>'required|min:3',
            'apellido'=>'required|min:4',
            'cedula'=>'required',
            'celular'=>'required|numeric',
            'fecha_nacimiento'=>'required|date_format:"Y-m-d',
            'correo'=>'required|email',
            'tarjeta_rfid'=>'required|max:8|alpha_num|regex:/^[0-9a-fA-F]+$/',
            'horario_normal'=>'required',

        ];
    }
}
