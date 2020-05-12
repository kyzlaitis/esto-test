<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{

    protected $fieldPrefix = 'data.attributes.';

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
            $this->fieldPrefix . 'name'       => 'unique:users,name',
            $this->fieldPrefix . 'email'      => 'email:rfc',
            $this->fieldPrefix . 'permission' => 'boolean',
        ];
    }

    public function attributes()
    {
        return [
            $this->fieldPrefix . 'email'      => 'email address',
            $this->fieldPrefix . 'permission' => 'permission',
            $this->fieldPrefix . 'name'       => 'name',
        ];
    }
}
