<?php

namespace App\Http\Requests\V1;

use App\Models\AttendanceRecord;
use Illuminate\Foundation\Http\FormRequest;

class AttendanceCheckInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'date' => 'required',
            'check_in' => 'required',
            'late_in_minutes' => 'nullable',
            'day_of_week' => 'required',
            'user_id' => 'required',
        ];
    }

    public function checkIn()
    {
        return AttendanceRecord::with('user')->create($this->validated());
    }
}
