<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLoanRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return match($this->method()){
            'POST' => $this->store(),
            'GET' => $this->view(),
            default => []
        };
        return [
            'status' => 'in:Pending,Approved,Paid'
        ];
    }

    protected function store(){
        return [
            'id' => 'required'
        ];
    }

    protected function view(){
        return [
            'status' => 'in:Pending,Approved,Paid'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
