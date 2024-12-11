<section class="section_cta">
  <div class="background-color-white">
    <div class="padding-vertical padding-large hide-mobile-portrait"></div>
  </div>
  <div class="padding-global">
    <div class="w-layout-grid component_cta container-large">
      <div class="content_cta padding-vertical" style="padding: 2.5rem;">
        <div class="heading-style-h2_hero margin-bottom margin-tiny">{{ __('marketing.tools.ctaTitle') }}</div>
        <p class="text-size-medium text-weight-medium max-width-small">{{ __('marketing.tools.ctaText') }}</p>
        <a class="button is-large color-primary-alt margin-top margin-custom2 w-button"
           href="{{ route('fe.contact') }}">{{ __('marketing.tools.contactUs') }}</a>
      </div>
      <div class="image-wrapper_cta">
        <img src="{{ asset('assets/imgs/lucky_diva_lets_start_a_conversation.png') }}"
             class="img_cta"
             style="top: -46px; height: calc(100% + 46px)"
        />
      </div>
    </div>
  </div>
</section><!-- /END CTA -->
