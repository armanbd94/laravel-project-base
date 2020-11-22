<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class MailSettingFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'=>false,
                'errors'=> $validator->errors()
            ],200)
        );
    }
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
            'mail_mailer'     => 'required|string',
            'mail_host'       => 'required|string',
            'mail_username'   => 'required|string',
            'mail_password'   => 'required|string',
            'mail_from_name'  => 'required|string',
            'mail_port'       => 'required|integer',
            'mail_encryption' => 'required|string',
        ];
    }
}
