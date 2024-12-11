@extends('layouts.website')
@section('content')
  <script>
    let processingText = "{{ __('contact.processing') }}";
    let submitText = "{{ __('contact.send') }}";

    $(document).ready(function () {
      $("#submit").on('click', async function (e) {
        let name = $("#full_name").val();
        let email = $("#contact_email").val();
        let subject = $("#subject_contact").val();
        let message = $("#message").val();

        let userMessage = '';

        $(this).val(processingText);

        try {

          const {data} = await axios(baseURL + 'api/submit-contact', {
            method: 'post',
            data: {
              name,
              email,
              subject,
              message
            }
          });

          userMessage = data.message;

          $(".form_message-success").show();
          $(".form_message-error").hide();
        } catch (err) {
          userMessage = err.response.data.message;
          if (!userMessage) userMessage = "Something went wrong. Please try again";
          $(".form_message-error").html(userMessage).show();
          $(".form_message-success").hide();
        }

        $(this).val(submitText);

      })

      $("#personal_data_checkbox").on('change', e => {
        if ($(e.target).is(':checked')) {
          $("#submit").removeClass('is-disabled');
        } else {
          $("#submit").addClass('is-disabled');
        }
      })
    })

  </script>
  <style>
    .is-disabled {
      pointer-events: none;
    }
  </style>

  <section class="section_contact mobile-margin">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="padding-top padding-medium">
            <div class="layout_contact">
              <div class="max-width-medium tablet-medium" style="grid-area: heading">
                <div class="margin-bottom margin-tiny">
                  <h1 class="heading-style-h2_hero">{{ __('contact.frm_title') }}</h1>
                </div>
                <p class="text-size-medium">
                  {!! __('contact.txt_sm') !!}
                </p>
                <div class="padding-bottom padding-xxlarge hide-mobile-landscape"></div>
                <div class="component_contact-social hide-mobile-landscape">
                  <a href="mailto:#" class="button is-text-icon is-contact w-inline-block">
                    <div class="icon-1x1-xsmall w-embed">
                      <img src="{{ asset('assets/imgs/icons/email.svg') }}"/>
                    </div>
                    <div>{{ config('website.official_email') }}</div>
                  </a>
                  <div class="line-divider"></div>
                  <x-social-links/>
                </div>
              </div>
              <div class="wrap_form-contact background-color-grey">
                <div class="margin-bottom margin-xsmall">
                  <div class="text-style-s1">{{ __('contact.title') }}</div>
                </div>
                <div class="form_component-contact w-form">
                  <form
                    class="form_contact"
                    action="javascript:">
                    <div class="form-wrap_contact">
                      <div class="form_field-wrapper">
                        <label for="full_name" class="form_label">
                          {{ __('contact.yourName') }} <span class="text-color-grey">*</span>
                        </label>
                        <input
                          class="form_input background-color-white w-input"
                          maxlength="256"
                          name="full_name"
                          placeholder="{{ __('contact.name') }} "
                          type="text"
                          id="full_name"
                        >
                      </div>
                      <div class="form_field-wrapper">
                        <label for="contact_email" class="form_label">
                          {{ __('contact.email') }}<span class="text-color-grey"> *</span>
                        </label>
                        <input
                          class="form_input background-color-white w-input"
                          maxlength="256"
                          name="email" data-name="email"
                          placeholder="email@domain.com"
                          type="email"
                          id="contact_email"
                        >
                      </div>
                      <div class="form_field-wrapper">
                        <label for="subject_contact" class="form_label">
                          {{ __('contact.subject') }}
                          <span class="text-color-grey">*</span>
                        </label>
                        <select
                          id="subject_contact"
                          name="subject_contact"
                          class="hs-input w-select">
                          @foreach(__('contact.subject_contact') as $key => $option)
                            <option value="{{ $key !== 'select_one' ? $key : '' }}">{{ $option }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form_field-wrapper">
                        <label for="message" class="form_label">
                          {{ __('Message') }}
                          <span class="text-color-grey">*</span>
                        </label>
                        <textarea
                          id="message"
                          name="message"
                          maxlength="5000"
                          placeholder="{{ __('contact.yourMessage') }}"
                          class="form_area background-color-white w-input"></textarea>
                      </div>
                      <div class="form_field-wrapper">
                        <label
                          id="personal_data"
                          class="w-checkbox form_checkbox agreement_check">
                          <div
                            class="w-checkbox-input w-checkbox-input--inputType-custom footer_checkbox-icon has-small-text on-grey"></div>
                          <input
                            type="checkbox"
                            name="Agreement"
                            id="personal_data_checkbox"
                            style="opacity:0;position:absolute;z-index:-1">
                          <span
                            for="Agreement" id="personal_data_label"
                            class="form_checkbox-label text-size-small w-form-label">{{ __('contact.agreement') }}</span>
                        </label>
                      </div>
                      <div class="form_field-wrapper">
                        <div id="recaptcha" class="recaptcha-container"></div>
                      </div>
                      <div class="button-wrap_form-contact margin-up">
                        <input
                          type="submit" data-wait="{{ __('contact.processing') }}"
                          id="submit"
                          class="button color_primary is-disabled"
                          value="{{ __('contact.send') }}">
                      </div>
                    </div>
                  </form>
                  <div class="form_message-success w-form-done">
                    <div>{{ __('contact.successMessage') }}</div>
                  </div>
                  <div class="form_message-error w-form-fail">
                    <div id="form-error-text">{{ __('contact.errorMessage') }}</div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <x-_partners :background="'background-color-primary'"/>
@endsection
