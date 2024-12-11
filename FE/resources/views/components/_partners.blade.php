<section class="section_partners-logo background-color-grey">
  <div class="padding-global {{ isset($background) ? $background : '' }}">
    <div class="container-large">
      <div class="padding-section-medium mobile_grey-section">
        <div class="component_partners-logo">
          <div class="max-width-medium tablet-small" style="grid-area: heading">
            <div class="padding-bottom padding-custom2">
              <h3 class="heading-style-h3">{{ __('marketing.tools.partnersTitle') }}</h3>
            </div>
            <a
              href="{{ route('fe.contact') }}"
              title="{{ __('marketing.tools.partnersLink') }}"
              class="button color_primary w-button">{{ __('marketing.tools.partnersLink') }}</a>
          </div>
          <div class="layout_partners-logo logos-grid" style="grid-area: component">
            <div class="collection_partners-logo">
              <div class="grid_partners-logo" role="list">
                @foreach(config('website.partners') as $key => $partner)
                  <div
                    role="listitem"
                    class="collection-item_partners-logo w-dyn-item"
                    style="display: flex;">
                    <a rel="nofollow"
                       href="{{ $partner['link'] }}"
                       target="_blank"
                       title="Partner {{ $key + 1  }}"
                       class="item_partners-logo w-inline-block">
                      <div class="hover_partners-logo" style="display: none; opacity: 0;"></div>
                      <img
                        loading="lazy"
                        alt="Partner {{ $key + 1  }}"
                        src="{{ $partner['img'] }}"
                        class="img_partners-logo">
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section><!-- /END PARTNERS -->

<style>
  .section_partners-logo .padding-global.background-color-primary .w-button {
    background-color: var(--tertiary--1);
    color: var(--primary--3);
  }

  .section_partners-logo .padding-global.background-color-primary .w-button:hover {
    background-color: var(--secondary--3);
    color: #fff;
  }
</style>
