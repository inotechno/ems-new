<?php

namespace App\Http\Requests;

use App\Helpers\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class MachineRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'ip_address' => 'required',
            'port' => 'required',
            'user' => 'required',
            'password' => 'required',
            'is_active' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'ip_address.required' => 'IP Address is required',
            'port.required' => 'Port is required',
            'user.required' => 'User is required',
            'password.required' => 'Password is required',
            'is_active.required' => 'Is Active is required',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'ip_address' => 'IP Address',
            'port' => 'Port',
            'user' => 'User',
            'password' => 'Password',
            'is_active' => 'Is Active',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, ApiResponse::validationError($validator->errors(), 422));
    }

    public function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(ApiResponse::unauthorized());
    }

    public function forbidden()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(ApiResponse::forbidden());
    }
}
