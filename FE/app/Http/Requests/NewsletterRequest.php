<?php

  namespace App\Http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class NewsletterRequest extends FormRequest
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
        'email' => 'required|email|max:255|unique:newsletters',
        'agree' => 'accepted'
      ];
    }

    public function messages()
    {
      return [
        'email.required' => 'Please fill email address',
        'email.unique' => 'This address aleardy exists in our database',
        'agree' => 'Please agree to the processing of your personal data'
      ];
    }
  }
