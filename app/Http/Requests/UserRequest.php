<?php

namespace App\Http\Requests;

use App\Enum\PermissionsEnum;
use App\Enum\RolesEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mapi\Easyapi\Requests\BaseRequest;

class UserRequest extends BaseRequest
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
            return array_merge($this->getRules, [

            ]);
        } else if ($method == 'post') {
            return array_merge($this->postRules, [
                'name' => ['required', 'string', 'unique:users'],
                'password' => ['required', 'string', 'min:5', 'confirmed'],
                'role' => ['required', 'string', Rule::in(enumAsArray(RolesEnum::class))],
                'permissions' => ['array', Rule::requiredIf(function () {
                    return $this->role != RolesEnum::Admin->value;
                })],
                'permissions.*' => ['sometimes', 'string', Rule::in(enumAsArray(PermissionsEnum::class))],
            ]);
        } elseif ($method == 'put') {
            return array_merge($this->postRules, [
                'name' => ['sometime', 'string', 'unique:users'],
                'password' => ['sometimes', 'string', 'min:5', 'confirmed'],
                'role' => ['sometimes', 'string', Rule::in(enumAsArray(RolesEnum::class))],
                'permissions' => ['sometimes', 'array'],
                'permissions.*' => ['sometimes', 'string', Rule::in(enumAsArray(PermissionsEnum::class))],
            ]);
        }
        return [];
    }
}
