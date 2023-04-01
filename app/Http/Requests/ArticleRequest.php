<?php

namespace App\Http\Requests;

use Mapi\Easyapi\Requests\BaseRequest;

class ArticleRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $method = strtolower($this->getMethod());
        if ($method == 'get') {
            return array_merge($this->getRules, []);
        } else if ($method == 'post') {
            return array_merge($this->postRules, [
                'title' => ['required', 'string', 'max:256'],
                'text' => ['required', 'string']
            ]);
        } else if ($method == 'put') {
            return array_merge($this->putRules, [
                'title' => ['sometimes', 'string', 'max:256'],
                'text' => ['sometimes', 'string']
            ]);
        }
        return [];
    }
}
