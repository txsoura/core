<?php

namespace Txsoura\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class CoreRequest extends FormRequest
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
    abstract protected function rules();
}
