<div class="wrapper_footer-buttom padding-vertical padding-small">
  <div class="max-width-xlarge">
    <p class="text-size-tiny text-color-grey margin-bottom margin-xxsmall">{{__('footer.copyTxt')}}</p>
    <div class="component_legal-links">
      <p class="text-size-tiny text-color-grey">© {{date('Y')}} {{__('footer.copy')}}</p>
      <div class="footer_legal-links no-wrap">
        <a
          href="{{ route('fe.privacy') }}"
          title="{{ __('footer.privacy') }}"
          class="button is-legal w-button">{{__('footer.privacy')}}</a>
        <div class="line-vertical_legal-links"></div>
        <a
          href="{{ route('fe.sitemap') }}"
          class="button is-legal w-button"
          title="{{__('footer.sitemap')}}"
        >{{__('footer.sitemap')}}</a>
      </div>
    </div>
  </div>
</div>
