<div class="wrapper_footer-mid padding-top padding-small">
  <div class="max-width-medium">
    <div class="header_content margin-bottom margin-xsmall">
      <div class="text-style-s1 padding-bottom padding-custom1">{{__('footer.newsletterTitle')}}</div>
      <p class="text-size-regular">{{__('footer.newsletterTxt')}}</p>
    </div>
    <div class="form_component w-form">
      <form class="form_get-pres" action="#">
        <div class="form-wrap_get-pres">
          <div class="form_field-wrapper">
            <label for="footer_email" class="form_label">{{__('global.email')}}</label>
            <input
              class="form_input w-input"
              maxlength="256"
              name="email"
              placeholder="Yourname@"
              type="email"
              id="footer_email"
              required="">
          </div>
          <button
            disabled
            data-wait="submitig..."
            class="button color_primary is-small">
            <div class="text-block-3">{{__('global.contactUs')}}</div>
          </button>
          <div class="form_message-warn">
            <div></div>
          </div>
          <div class="form_message-success w-form-done" role="region" id="newsletter_success_message">
            <div>{{__('articles.successMessage')}}</div>
          </div>
        </div>
        <div class="form_checkbox-wrapper">
          <label class="w-checkbox form_checkbox agreement_check">
            <div class="w-checkbox-input w-checkbox-input--inputType-custom footer_checkbox-icon"></div>
            <input
              type="checkbox"
              name="agree"
              value="1"
              data-name="Agreement"
              style="opacity:0;position:absolute;z-index:-1"/>
            <span class="form_checkbox-label w-form-label">I agree to the processing of my personal data</span>
          </label>
          <label
            id="consultation_check" class="w-checkbox form_checkbox">
            <div class="w-checkbox-input w-checkbox-input--inputType-custom footer_checkbox-icon"></div>
            <input
              type="checkbox"
              name="consultation"
              id="consultation"
              data-name="consultation"
              value="1"
              style="opacity:0;position:absolute;z-index:-1"/>
            <span class="form_checkbox-label w-form-label">I’d love to get a consultation</span>
          </label>
          <label
            id="news_subscribe_check"
            class="w-checkbox form_checkbox"
          >
            <div class="w-checkbox-input w-checkbox-input--inputType-custom footer_checkbox-icon"></div>
            <input
              type="checkbox"
              name="news_subscribe"
              id="news_subscribe"
              data-name="news_subscribe"
              style="opacity:0;position:absolute;z-index:-1">
            <span class="form_checkbox-label w-form-label">I’d love to subscribe to BGaming news (No spam)</span>
          </label>
        </div>
      </form>
    </div>
  </div>
  <div class="content_social-links">
    <a
      href="{{ url('/') }}"
      title="{{ env('APP_NAME') }}"
      aria-current="page"
      class="margin-bottom margin-xsmall w-inline-block w--current">
      <img alt="{{ env("APP_NAME") }}" src="{{ asset('/assets/imgs/logo.png') }}" class="img_logo-footer"/>
    </a>
    <x-social-links/>
  </div>
</div>
