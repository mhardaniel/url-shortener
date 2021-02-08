<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUrlRequest extends FormRequest
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
		return array(
			'original_link' => 'bail|required|url',
			// 'original_link' => 'bail|required|unique:urls,original_link',
		);
	}

    public function messages()
    {
    return [
        'original_link.url' => 'Invalid URL',
        'original_link.required' => 'Invalid URL',
    ];
    }
}
