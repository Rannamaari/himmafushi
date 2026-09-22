<?php

namespace App\Http\Requests;

use App\Support\Countries;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGuesthouseBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guesthouse_id' => ['nullable', 'exists:guesthouses,id'],
            'name' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:40', 'regex:/^[0-9+() .-]{6,40}$/'],
            'country' => ['required', 'string', 'max:100', Rule::in(array_keys(Countries::all()))],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
