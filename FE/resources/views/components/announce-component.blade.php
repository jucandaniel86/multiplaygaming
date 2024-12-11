@if($announce)
  <address
    class="padding-global banner-promo"
    style="display: none;"
  >
    <div class="component_banner-promo container-large padding-vertical padding-xtiny">
      <div class="banner-promo__content">
        <div class="text-size-medium text-weight-bold">
          <em class="italic-text">{{ $announce->title }}</em>
        </div>
        <div class="text-size-small text-weight-medium">{{ $announce->subtitle }}</div>
      </div>
      <div class="button-wrap gap-medium">
        <a href="javascript:" class="button is-text-icon is-small hide_button w-inline-block">
          <div class="align-center w-embed"></div>
          <div class="text-block-9">{{__('global.hide')}}</div>
        </a>
        @if($announce->link)
          <a
            href="{{ $announce->link }}"
            title="{{ $announce->title }}"
            target="_blank" class="button is-small hide_button w-button">
            {{__('global.learnMore')}}
          </a>
        @endif
      </div>
    </div>
  </address>
@endif
