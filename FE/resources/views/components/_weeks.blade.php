<section class="section_weeks">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-xlarge">
        <div class="w-layout-grid component_weeks">
          <div class="weeks_image-wrapper" style="grid-area: text">
            <img src="{{ (isset($image)) ? asset($image) : asset('assets/imgs/dummy_588x356.png') }}"
                 class="img_weeks"/>
          </div>
          <div class="max-width-medium" style="grid-area: img">
            <div class="padding-bottom padding-custom2">
              @if(isset($title))
                <div class="padding-bottom padding-xxsmall">
                  <h3 class="heading-style-h3">{{ $title }}</h3>
                </div>
              @endif
              @if(isset($text))
                <p class="text-size-medium">
                  {!! $text !!}
                </p>
              @endif
            </div>
            @if(isset($button))
              <div class="button-wrap">
                <a class="button w-button {{ (isset($button['class'])) ? $button['class'] : '' }}"
                   title="{{ $button['label'] }}"
                   href="{{ (isset($button['route'])) ? route($button['route']) : '#' }}">{{ $button['label'] }}</a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
