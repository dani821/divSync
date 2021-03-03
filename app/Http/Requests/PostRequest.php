<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $rule = ($this->getMethod() == 'PUT' || $this->getMethod() == 'PATCH')
            ? 'required|string|min:3|max:255|unique:posts,title,'.$this->route('post')
            : 'required|string|min:3|max:255|unique:posts';

        return [
            'title' => $rule,
            'description' => 'required|string'
        ];
    }
}
