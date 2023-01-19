<?php

namespace App\Http\Requests;

use App\Repositories\Crypto\CryptoRepository;
use Illuminate\Foundation\Http\FormRequest;

class BuyCryptoRequest extends FormRequest
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
    public function rules(CryptoRepository $cryptoRepository)
    {
        $userAccount = auth()->user()->accounts()->where('number', $this->input('account'))->first();
        $crypto = $cryptoRepository->find($this->route('id'), $userAccount->currency);

        return [
            'account' => 'required|exists:accounts,number,user_id,' . auth()->user()->id,
            'amount' => 'required|numeric|min:0.01|max:' . auth()->user()->accounts()->where('number', $this->input('account'))->first()->balance / $crypto->price,
        ];
    }
}
