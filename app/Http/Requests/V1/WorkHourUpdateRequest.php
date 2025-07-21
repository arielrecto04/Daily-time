<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\WorkHour;

class WorkHourUpdateRequest extends FormRequest
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
            'day_of_week' => 'required',
            'day_period' => 'required',
            'hours_from' => 'required',
            'hours_to' => 'required',
            'duration_days' => 'required',
            'work_schedule_id' => 'required|exists:work_schedules,id',
        ];
    }

    public function update($id)
    {
        return WorkHour::findOrFail($id)->update([
            ...$this->validated()
        ]);
    }
}
