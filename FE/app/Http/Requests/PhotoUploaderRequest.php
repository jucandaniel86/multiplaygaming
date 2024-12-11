<?php

  namespace App\Http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class PhotoUploaderRequest extends FormRequest
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
        'table' => 'required',
        'column' => 'required',
        'id' => 'required',
        'file' => 'mimes:jpeg,jpg,png,gif,webp|required|max:10000'
      ];
    }
  }
