<?php

namespace App\Http\Requests\V1;

use App\Models\OvertimeApplication;
use Illuminate\Foundation\Http\FormRequest;

class OvertimeApplicationStoreRequest extends FormRequest
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
            'attendance' => 'required',
            'overtime_in_minutes' => 'required',
            'overtime_in_hours' => 'required',
            'date' => 'required',
            'user_id' => 'required',
        ];
    }

    public function store()
    {
        return OvertimeApplication::create($this->validated());
    }
}
