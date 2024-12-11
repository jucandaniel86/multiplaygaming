<section class="section_highlights padding-global">
  <div class="container-medium padding-section-large pt-0 mobile-small">
    <div class="component_highlights">
      <div class="component_heading-center margin-bottom margin-xxlarge">
        <img src="{{ isset($icon) ? $icon : asset('assets/imgs/blue_coin_jeton.png') }}"
             loading="lazy"
             alt=""
             class="img_highlights margin-bottom margin-xxsmall">
        <h2 class="heading-style-h2_hero text-align-center">{{
	          isset($title) ? $title : __('about.company.highlightTitle') }}
        </h2>
        @if(isset($text))
          <p class="text_highlights">{{ $text }}</p>
        @endif
      </div>
      <div class="w-layout-grid layout_highlights margin-bottom margin-small">
        @foreach(__((isset($langSource) ? $langSource : 'about.company.hightlightItems')) as $key => $item)
          <div class="item_highlights">
            @if(isset($item['img']))
              <img
                src="{{ asset('assets/imgs/highlight/' . $item['img']) }}"
                alt="{{ $item['title'] }}"
                style="width: 70px; margin: 0 auto"
              />
            @endif
            <div style="font-size:1.2rem; line-height: 1.6rem; ">{!! $item['title'] !!}</div>
            <div class="text_highlights text-center">{!!  $item['txt'] !!}</div>
          </div>

          @if(@count(__('about.company.hightlightItems')) > $key + 1)
            <div class="line-vertical_highlights hide-mobile-landscape"></div>
          @endif
        @endforeach
      </div>
    </div>
  </div>
</section>
<style>
  .text_highlights.text-center {
    text-align: center;
    width: 100%;
    font-size: .8rem;
  }

  .text_highlights.text-center li {
    text-align: left;
  }

  .text_highlights.text-center ul {
    padding-left: 1rem;
  }

  .pt-0 {
    padding-top: 0 !important;;
  }
</style>
