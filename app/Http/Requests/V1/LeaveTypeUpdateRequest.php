<?php

namespace App\Http\Requests\V1;

use App\Models\LeaveType;
use Illuminate\Foundation\Http\FormRequest;

class LeaveTypeUpdateRequest extends FormRequest
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
            'is_active' => 'required',
            'is_credited' => 'required',
        ];
    }

    public function update($id)
    {
        $leaveType = LeaveType::findOrFail($id);
        return $leaveType->update($this->validated());
    }
}
