@if(isset($easdasda))
  <section class="section_partners-logo background-color-grey" @if(isset($style)) style="{{ $style }}" @endif>
    <div class="padding-global {{ isset($background) ? $background : '' }}">
      <div class="container-large">
        <div class="padding-section-medium mobile_grey-section">
          <div class="{{ $partner_type == "operator" ? "component_partners-logo" : "component_platforms-logo" }} ">
            <div class="max-width-medium tablet-small" style="grid-area: heading">
              <div class="padding-bottom padding-custom2">
                <h3 class="heading-style-h3">{{ $title }}</h3>
              </div>
              <a
                href="{{ route('fe.contact') }}"
                title="{{ __('marketing.tools.partnersLink') }}"
                class="button color_primary w-button">{{ __('marketing.tools.partnersLink') }}</a>
            </div>
            <div
              class="{{ $partner_type == "platform" ? 'grid_platforms-logo' : 'layout_partners-logo' }} logos-grid"
              style="grid-area: component">
              <div class="collection_partners-logo">
                <div class="grid_partners-logo" role="list">
                  @foreach($partners as $key => $partner)
                    <div
                      role="listitem"
                      class="collection-item_partners-logo w-dyn-item"
                      style="display: flex;">
                      <a rel="nofollow"
                         href="{{ $partner->external_url }}"
                         target="_blank"
                         title="Partner {{ $partner->name }}"
                         class="item_partners-logo w-inline-block">
                        <div class="hover_partners-logo" style="display: none; opacity: 0;"></div>
                        <img
                          loading="lazy"
                          alt="Partner {{ $partner->name  }}"
                          src="{{ $partner->logo_url }}"
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

    .component_platforms-logo {
      grid-column-gap: 1.25rem;
      grid-row-gap: 1.25rem;
      grid-template: "component component component component heading heading" / 1fr 1fr 1fr 1fr 1fr 1fr;
      grid-auto-columns: 1fr;
      align-items: center;
      justify-items: start;
      display: grid;
    }

    .grid_platforms-logo {
      grid-column-gap: 0rem;
      grid-row-gap: 0rem;
      grid-template-rows: auto;
      grid-template-columns: 12.5rem 12.5rem 12.5rem;
      grid-auto-columns: 1fr;
      align-items: start;
      justify-items: stretch;
      width: 100%;
      display: grid;
    }
  </style>
@endif
