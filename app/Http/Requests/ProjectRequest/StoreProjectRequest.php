<?php

namespace App\Http\Requests\ProjectRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'required|in:pending,active,completed,on_hold',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'owner_id'     => 'required|exists:users,id',
            'member_ids'   => 'nullable|array',
            'member_ids.*' => 'exists:users,id',
        ];
    }
}
