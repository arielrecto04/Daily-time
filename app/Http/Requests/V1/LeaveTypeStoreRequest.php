<?php

namespace App\Http\Requests\V1;

use App\Models\LeaveType;
use Illuminate\Foundation\Http\FormRequest;

class LeaveTypeStoreRequest extends FormRequest
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
            'is_active' => 'nullable',
            'is_credited' => 'nullable',
        ];
    }

    public function store()
    {
        return LeaveType::create($this->validated());
    }
}
