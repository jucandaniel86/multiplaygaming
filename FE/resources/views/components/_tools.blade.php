<section class="section_marketing-tools">
  <div class="padding-global">
    <div class="container-large">
      <div class="">
        <div class="component_partners">
          <div class="padding-bottom padding-medium"></div>
          @if(isset($title))
            <div class="margin-bottom margin-large">
              <div class="max-width-medium">
                <h2 class="heading-style-h3">{{ $title }}</h2>
              </div>
            </div>
          @endif
          @if(isset($list) && is_array($list) && count($list))
            <div class="margin-bottom margin-xxlarge">
              <div class="w-layout-grid layout_partners">
                @foreach($list as $item)
                  <a
                    title="{{ $item['title'] }}"
                    href="{{ $item['url'] != "" ? route($item['url']) : '#' }}"
                    class="item_partners link w-inline-block">
                    <div class="margin-bottom margin-tiny">
                      <div class="margin-bottom margin-small">
                        <div class="icon_wrap"><img
                            src="{{ asset('assets/imgs/' . $item['icon']) }}"
                            loading="lazy" alt="" class="icon-1x1-medium"></div>
                      </div>
                      @if($item['title'])
                        <div class="padding-bottom padding-custom1">
                          <div>{{ $item['title'] }}</div>
                        </div>
                      @endif
                      @if(isset($item['text']))
                        <p class="text-size-regular">{{ $item['text'] }}</p>
                      @endif
                    </div>
                    <div class="button is-text">
                      <div>{{ __('marketing.tools.learnMore') }}</div>
                      <div class="icon_button-text animated w-embed">
                        <x-icons.arrow-right/>
                      </div>
                    </div>
                  </a>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section><!-- /END TOOLS -->
