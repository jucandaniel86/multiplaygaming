<section>
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-medium">
        <div class="padding-bottom padding-small">
          <div
            class="{{ isset($sectionName) ? $sectionName : 'layout_lavels' }}"
          >
            <div class="sticky-area">
              <div class="max-width-small sticky">
                @if(isset($title))
                  <div class="padding-bottom padding-xxsmall">
                    <h2 class="heading-style-h3">{{ $title }}</h2>
                  </div>
                @endif
                @if(isset($text))
                  <p class="text-size-medium">{{ $text }}</p>
                @endif
                @if(isset($button))
                  <div class="padding-top padding-custom2">
                    <div class="button-wrap">
                      <a class="button w-button {{ (isset($button['class'])) ? $button['class'] : 'color_primary' }}"
                         title="{{ $button['label'] }}"
                         href="{{ (isset($button['route'])) ? route($button['route']) : '#' }}">{{ $button['label'] }}</a>
                    </div>
                  </div>
                @endif
              </div>
            </div><!-- end sticky-area -->
            <div class="{{ isset($componentName) ? $componentName : 'component_levels' }}">
              {{ $slot }}
            </div>
            <!-- /end components_levels -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
