<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShipBerthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'coordinates' => 'required',
            'length' => 'required',
            'width' => 'required',
            'depth' => 'required',
            'rotation' => 'required',
            'additional_params_names' => 'required',
            'additional_params_values' => 'required',
            'map_type' => 'required',
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'coordinates.required' => __('messages.coordinates_required'),
        ];
    }

}
