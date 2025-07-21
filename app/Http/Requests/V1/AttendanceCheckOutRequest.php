<?php

namespace App\Http\Requests\V1;

use App\Models\AttendanceRecord;
use Illuminate\Foundation\Http\FormRequest;

class AttendanceCheckOutRequest extends FormRequest
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
            'check_out' => 'required',
            'overtime_in_minutes' => 'nullable',
            'duration_days' => 'nullable',
        ];
    }

    public function checkOut($id)
    {
        $attendanceRecord = AttendanceRecord::findOrFail($id);
        $attendanceRecord->update([
            'check_out' => $this->validated('check_out'),
            'overtime_in_minutes' => $this->validated('overtime_in_minutes'),
            'duration_days' => $this->validated('duration_days'),
        ]);
        return $attendanceRecord;
    }
}
