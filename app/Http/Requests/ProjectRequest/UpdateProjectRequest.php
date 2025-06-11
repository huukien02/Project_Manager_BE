<?php

namespace App\Http\Requests\ProjectRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'sometimes|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'sometimes|in:pending,active,completed,on_hold',
            'start_date'   => 'sometimes|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'owner_id'     => 'sometimes|exists:users,id',
            'member_ids'   => 'nullable|array',
            'member_ids.*' => 'exists:users,id',
        ];
    }
}
