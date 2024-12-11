<div class="margin-bottom margin-xsmall">
  @if(isset($title) && !empty($title))
    <div class="layout_toggle">
      <h1 class="heading-style-h3">{{ $title }}</h1>
    </div>
  @endif
</div>
<div class="margin-bottom margin-tiny">
  <div class="max-width-xsmall mobile-full">
    <div class="item_search">
      <img src="{{ asset('assets/imgs/icons/search.svg') }}" alt="Search" class="icon-1x1-xsmall"/>
      <input
        class="field_search w-input"
        maxlength="256"
        name="search_query"
        placeholder="{{ __('games.search') }}"
        data-type="{{ (isset($dataType)) ? $dataType : 'articles' }}"
        type="text"
        id="field-2"
        required="">
    </div>
  </div>
</div>
