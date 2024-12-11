<section class="section_banner">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-medium">
        <div class="component_banner">
          <div class="text-wrap_banner">
            <div class="max-width-medium">
              @if(isset($title))
                <div class="margin-bottom margin-tiny">
                  <h2 class="heading-style-h1">{{ $title }}</h2>
                </div>
              @endif
              @if(isset($text))
                <div class="max-width-small">
                  <p class="text-size-medium text-weight-medium">{!! $text !!}</p>
                </div>
              @endif
              @if(isset($button))
                <div class="margin-top margin-medium">
                  <a class="button w-button {{ (isset($button['class'])) ? $button['class'] : 'color_primary' }}"
                     title="{{ $button['label'] }}"
                     href="{{ (isset($button['route'])) ? route($button['route']) : '#' }}">{{ $button['label'] }}</a>
                </div>
              @endif
            </div>
          </div>
          @if(isset($image))
            <img
              src="{{ $image }}"
              loading="lazy"
              alt=""
              class="img_banner paralax"
            >
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
