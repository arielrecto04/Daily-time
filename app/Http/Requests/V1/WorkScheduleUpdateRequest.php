<?php

namespace App\Http\Requests\V1;

use App\Models\WorkSchedule;
use Illuminate\Foundation\Http\FormRequest;

class WorkScheduleUpdateRequest extends FormRequest
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
            'hours_week' => 'required',
            'average_hour_per_day' => 'required',
        ];
    }

    public function update($id)
    {
        return WorkSchedule::findOrFail($id)->update([
            ...$this->validated()
        ]);
    }
}
