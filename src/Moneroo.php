<?php

namespace Moneroo;

use Exception;
use Illuminate\Support\Facades\Validator;
use Moneroo\Exceptions\InvalidPayloadException;

class Moneroo
{
    use Traits\Request;

    protected readonly ?string $publicKey;

    protected readonly ?string $secretKey;

    protected readonly string $baseUrl;

    public function __construct()
    {
        $this->publicKey = config('moneroo.publicKey');
        $this->secretKey = config('moneroo.secretKey');

        $this->baseUrl = config('moneroo.devMode') === true
            ? config('moneroo.devBaseUrl')
            : Config::BASE_URL;

        if (empty($this->publicKey) || ! is_string($this->publicKey)) {
            throw new InvalidPayloadException('Moneroo public key is not set or not a string.');
        }

        if (empty($this->secretKey) || ! is_string($this->secretKey)) {
            throw new InvalidPayloadException('Moneroo secret key is not set or not a string.');
        }
    }

    public function validateData(array $data, $rules): void
    {
        try {
            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                throw new InvalidPayloadException(implode(', ', $validator->errors()->all()));
            }
        } catch (Exception $e) {
            throw new InvalidPayloadException($e->getMessage());
        }
    }
}
