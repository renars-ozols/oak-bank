<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BalanceTransferRequest extends FormRequest
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
        $codes = explode(' ', auth()->user()->code_card);

        return [
            'account' => 'required|exists:accounts,number,user_id,' . auth()->user()->id,
            'recipient' => 'required|exists:accounts,number',
            'amount' => 'required|numeric|min:0.01|max:' . auth()->user()->accounts()->where('number', $this->input('account'))->first()->balance,
            'code' => 'required|in:' . $codes[$this->session()->get('codeIndex')]
        ];
    }
}
