<?php

namespace App\Http\Requests\V1;

use App\Models\LeaveApplication;
use Illuminate\Foundation\Http\FormRequest;

class LeaveApplicationUpdateRequest extends FormRequest
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
            'descriptions' => 'required',
            'total_days' => 'required',
            'leave_type_id' => 'required',
            'end_date' => 'required',
            'start_date' => 'required',
            'user_id' => 'required',
        ];
    }

    public function update($id)
    {
        $leaveApplication = LeaveApplication::findOrFail($id);

        $leaveApplication->update($this->validated());


        return $leaveApplication->refresh();
    }
}
