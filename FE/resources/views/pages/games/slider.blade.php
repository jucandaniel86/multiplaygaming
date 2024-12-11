<section class="section_gallery overflow-hidden">
  <div class="padding-global">
    <div class="container-large">
      <div class="padding-section-medium">
        <div class="padding-top padding-xsmall">
          <div class="max-width-medium">
            <div class="margin-bottom margin-small">
              <h3 class="heading-style-h3">{{ __('games.single.gallery') }}</h3>
            </div>
          </div>
        </div>
        <div class="slider_gallery w-slider">
          <div class="mask_gallery w-slider-mask">
            <div class="w-slider-aria-label">Slide 2 of 5.</div>
            @foreach($game->gallery as $key => $item)
              <div
                class="slide_gallery w-slide"
                style="transform: translateX(0px); opacity: 1;"
              >
                <div class="item_game-gallery">
                  <img src="{{ $item->thumbnail }}"
                       alt="Photo gallery {{ $key + 1 }} for {{ $game->game_name }} game"
                       class="img_game-gallery"/>
                </div>
              </div>
            @endforeach
          </div>
          <div class="gallery_arrow is-left w-slider-arrow-left" role="button">
            <x-icons.arrow-left :fill="'black'"/>
          </div>
          <div class="gallery_arrow w-slider-arrow-right" role="button">
            <x-icons.arrow-right :fill="'black'"/>
          </div>
          <div class="show-mobile-landscape career w-slider-nav">
            @foreach($game->gallery as $key => $item)
              <div
                class="w-slider-dot {{ $key == 0 ? 'w-active' : '' }}"
                aria-label="Show slide {{ $key + 1 }} of {{ count($game->gallery) }}"
                aria-pressed="false"
                role="button"
                tabindex="-1"
                style="margin-left: 5px; margin-right: 5px;"></div>
            @endforeach
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

