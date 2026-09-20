<?php

namespace App\Http\Requests;

use App\Models\Transfer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreTransferBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transfer_id' => ['required', 'exists:transfers,id'],
            'customer_type' => ['required', Rule::in(['local', 'tourist'])],
            'name' => ['required', 'string', 'max:120'],
            'whatsapp' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'travel_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['nullable', 'string', 'max:50'],
            'passengers' => ['required', 'integer', 'min:1', 'max:50'],
            'infants' => ['nullable', 'integer', 'min:0', 'max:20'],
            'flight_number' => ['nullable', 'string', 'max:50'],
            'flight_time' => ['nullable', 'date_format:H:i'],
            'pickup_location' => ['nullable', 'string', 'max:255'],
            'dropoff_location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->has('transfer_id') || $validator->errors()->has('travel_date')) {
                return;
            }

            $transfer = Transfer::find($this->integer('transfer_id'));
            $date = $this->date('travel_date');

            if (! $transfer || ! $transfer->active || ! $date || ! in_array(strtolower($date->englishDayOfWeek), $transfer->operating_days ?? [], true)) {
                $validator->errors()->add('travel_date', 'This departure is not operating on the selected date. Please choose another scheduled departure.');
            }
        });
    }
}
