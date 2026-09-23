<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'activity_id' => ['required', 'exists:activities,id'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'participants' => ['required', 'integer', 'min:1', 'max:30'],
            'name' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:40', 'regex:/^[0-9+() .-]{6,40}$/'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }
}
