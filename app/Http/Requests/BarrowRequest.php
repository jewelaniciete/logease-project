<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BarrowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacher_id' => 'required|exists:teachers,id',
            'key_id' => 'required|exists:keys,id',
            'barcode' => 'required',
            // Add other rules as needed
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'teacher_id.required' => 'The teacher is required. Please scan a valid teacher barcode.',
            'teacher_id.exists' => 'The selected teacher is invalid. Make sure the barcode corresponds to a registered teacher.',
        ];
    }
}
