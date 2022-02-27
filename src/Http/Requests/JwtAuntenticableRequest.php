<?php

namespace Davidkiarie\NextLayerJwtPackage\Http\Requests;

use Davidkiarie\NextLayerJwtPackage\Tools\CreateJwt;
use Illuminate\Foundation\Http\FormRequest;
use Davidkiarie\NextLayerJwtPackage\Rules\UserIdExistInEitherTable;
class JwtAuntenticableRequest extends FormRequest
{
   use CreateJwt;
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
            "user_id"=>["required",new UserIdExistInEitherTable(($this))],
            "password"=>["required"]
        ];
    }
}
