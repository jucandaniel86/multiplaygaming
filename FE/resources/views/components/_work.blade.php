<section class="section_partners">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-medium">
        <div class="component_partners">
          <div class="margin-bottom margin-small">
            <h2 class="heading-style-h3">{{ __('global.whoWorkTitle') }}</h2>
          </div>
          <div class="collection-list-wrapper">
            <div class="collection-list_partners">
              @foreach(config('dummy.whoWorksList') as $item)
                <div class="item_logos_desctop w-dyn-item" style="display: flex">
                  @if(isset($item['logo']) && $item['logo'] !== "")
                    <a
                      rel="nofollow"
                      href="{{ isset($item['url']) && $item['url'] !== '' ? $item['url'] : '#' }}"
                      target="_blank"
                      style="display: flex"
                      class="card_partners-logo w-inline-block">
                      <img
                        loading="lazy"
                        alt="{{ $item['name'] }}"
                        src="{{ asset('assets/imgs/' . $item['logo'])  }}"
                        class="image_partners-logo">
                    </a>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
