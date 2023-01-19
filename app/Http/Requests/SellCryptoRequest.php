<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellCryptoRequest extends FormRequest
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
        $userAccount = auth()->user()->accounts()->where('number', $this->input('account'))->first();

        return [
            'account' => 'required|exists:accounts,number,user_id,' . auth()->user()->id,
            'amount' => 'required|numeric|min:0|max:' . $userAccount->cryptos()->where('crypto_id', $this->route('id'))->first()->amount,
        ];
    }
}
