<?php

namespace App\Http\Requests\V1;

use App\Models\LeaveApplication;
use Illuminate\Foundation\Http\FormRequest;

class LeaveApplicationStoreRequest extends FormRequest
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
            'total_days' => 'nullable',
            'leave_type_id' => 'required',
            'user_id' => 'required',
            'attachments' => 'required',
        ];
    }

    public function store()
    {
        return LeaveApplication::create($this->validated());
    }
}
