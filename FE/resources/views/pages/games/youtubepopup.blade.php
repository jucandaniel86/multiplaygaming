<div class="overlay_youtube" id="youtube_embeded_popup" style="display: none;">
  <div class="card_pop-up" style="padding: 1rem;">
    {!! $game->trailer_url !!}
    <div class="padding-top padding-xsmall">
      <button onclick="closeYTPopup()" class="button is-small">Close</button>
    </div>
  </div>
</div>
<style>
  .overlay_youtube {
    z-index: 999;
    background-color: rgba(0, 0, 0, .5);
    justify-content: center;
    align-items: center;
    display: none;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
  }
</style>
