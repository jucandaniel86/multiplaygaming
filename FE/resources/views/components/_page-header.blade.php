<section class="section_block-hero mobile-margin-small">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-small">
        <div class="padding-top">
          <div class="layout_block-hero {{ isset($background) ? $background : 'background-color-secondary' }}">
            <div class="max-width-large align-center_tools">
              @if(isset($title))
                <div class="margin-bottom margin-tiny">
                  <h1
                    class="heading-style-h2_hero {{ isset($textColor) ? $textColor : '' }}">{{ $title }}</h1>
                </div>
              @endif
              @if(isset($text))
                <div class="margin-bottom margin-small">
                  <div class="max-width-medium">
                    <p
                      class="text-size-medium text-weight-medium {{ isset($textColor) ? $textColor : '' }}">
                      {!! $text !!}
                    </p>
                  </div>
                </div>
              @endif
              @if(isset($button) && isset($button['label']))
                <div class="padding-top padding-custom1">
                  <a href="{{ route($button['route']) }}"
                     class="button w-button {{ isset($button['class']) ? $button['class'] : 'color_primary on-secondary' }} ">{{ $button['label'] }}</a>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
