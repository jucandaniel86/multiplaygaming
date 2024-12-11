@if(isset($features) && is_array($features) && count($features))
  <section class="section_features">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="padding-bottom padding-medium">
            <div class="w-layout-grid layout_features">
              @foreach($features as $feature)
                <div class="item_features">
                  <div class="margin-bottom margin-small">
                    @if(isset($feature['icon']))
                      <img
                        src="{{ asset($feature['icon']) }}"
                        loading="lazy"
                        alt=""
                        class="img_feature">
                  </div>
                  @endif
                  @if(isset($feature['title']))
                    <div class="padding-bottom padding-custom1">
                      <div>{!! $feature['title'] !!}</div>
                    </div>
                  @endif
                  @if(isset($feature['txt']))
                    <p class="text-size-regular">{!! $feature['txt'] !!}</p>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endif
