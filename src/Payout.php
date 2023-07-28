<?php

namespace Moneroo;

class Payout extends Moneroo
{
    public function create(array $data): object
    {
        $this->validateData($data, $this->payoutValidationRules());

        return $this->sendRequest('post', $data, '/payouts/initialize');
    }

    public function verify(string $payoutTransactionId): object
    {
        return $this->sendRequest('get', [], '/payouts/' . $payoutTransactionId . '/verify');
    }

    public function get(string $payoutTransactionId): object
    {
        return $this->sendRequest('get', [], '/payouts/' . $payoutTransactionId);
    }

    private function payoutValidationRules(): array
    {
        return [
            'amount'                 => 'required|numeric|gt:0',
            'currency'               => ['required', 'string'],
            'description'            => ['string', 'required', 'max:155'],
            'customer'               => 'required|array',
            'customer.*'             => 'string',
            'customer.email'         => 'email|required',
            'customer.first_name'    => 'string|max:100|required',
            'customer.last_name'     => 'string|max:100|required',
            'customer.phone'         => 'integer|nullable',
            'customer.address'       => 'string|max:200|nullable',
            'customer.city'          => 'string|max:100|nullable',
            'customer.state'         => 'string|max:100|nullable',
            'customer.country'       => 'string|max:10|nullable',
            'customer.zip'           => 'string|max:100|nullable',
            'metadata'               => ['array', 'max:10', 'nullable'],
            'metadata.*'             => ['string'],
            'method'                 => ['required', 'string'],
        ];
    }
}
