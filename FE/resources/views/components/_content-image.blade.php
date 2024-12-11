@php
  if(!isset($textLeft))
    $textLeft = true;
@endphp
<section class="section_free-spins overflow-hidden">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-large mobile-medium">
        <div class="w-layout-grid {{ $textLeft ? 'component_marketing-tools' : 'invert-component_marketing-tools' }}">
          <div class="max-width-medium" style="grid-area: text">
            <div class="margin-bottom">
              @if(isset($title))
                <div class="padding-bottom padding-xxsmall">
                  <h2 class="heading-style-h3">{{ $title }}</h2>
                </div>
              @endif
              @if(isset($text1))
                <div class="margin-bottom margin-xxsmall">
                  <p class="text-size-medium">{!! $text1 !!}</p>
                </div>
              @endif
              @if(isset($text2))
                <p class="text-size-medium">{!! $text2 !!}</p>
              @endif
            </div>
            @if(isset($list) && is_array($list) && count($list))
              <div class="list_marketing">
                @foreach($list as $item)
                  <div class="item_marketing">
                    <div class="wrap-icon_marketing">
                      <div class="align-center w-embed">
                        <x-icons.verify :fill="'#1f5cae'"/>
                      </div>
                    </div>
                    <div class="max-width-small">
                      @if(isset($item['title']))
                        <div class="text-style-s3">{!! $item['title'] !!}</div>
                      @endif
                      @if(isset($item['txt']))
                        <p class="text-size-regular">{!! $item['txt'] !!}</p>
                      @endif
                    </div>
                  </div>
                @endforeach
              </div>
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

          <div class="header_image-wrapper" style="grid-area: img">
            <img
              loading="lazy"
              src="{{ isset($image) ? asset($image) : asset('assets/imgs/dummy_569x550.png') }}"
              alt=""
              class="img_hero-back"
              style="object-fit: contain"
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
