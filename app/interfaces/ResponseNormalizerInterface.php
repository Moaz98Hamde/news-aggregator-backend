<?php

namespace App\Interfaces;

use Illuminate\Validation\ValidationException;

interface ResponseNormalizerInterface
{
    /**
     * Normalize the given JSON string.
     *
     * @param string $jsonResponse
     * @return array
     * @throws ValidationException
     */
    public function normalize(string $jsonResponse): array;

    /**
     * Normalize the structure of the data array.
     *
     * @param array $data The input data array.
     * @return array The normalized array with filtered data.
     */
    public function normalizeStructure(array $data): array;

}
