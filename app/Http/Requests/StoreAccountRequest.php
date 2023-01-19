<?php

namespace App\Http\Requests;

use App\Repositories\Currencies\CurrencyRepository;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
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
    public function rules(CurrencyRepository $currencyRepository)
    {
        return [
            'name' => 'required|string|max:15',
            'currency' =>'required|in:' . $currencyRepository->all()->pluck('symbol')->implode(','),
        ];
    }
}
