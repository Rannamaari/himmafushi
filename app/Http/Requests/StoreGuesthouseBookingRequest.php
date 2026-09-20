<?php

namespace App\Http\Requests;

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
            'customer_type' => ['required', Rule::in(['local', 'tourist'])],
            'name' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1', 'max:20'],
            'children' => ['nullable', 'integer', 'min:0', 'max:10'],
            'room_preference' => ['nullable', 'string', 'max:255'],
            'meal_plan' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
