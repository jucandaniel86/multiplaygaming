<!-- NOT FOUND -->
<div
  class="margin-vertical margin-large align-center"
  id="article-no-results"
  @if($condition) style="display: none" @endif
>
  <div class="max-width-xsmall text-align-center">
    <div class="margin-bottom margin-xxsmall">
      <div class="img_no-results">
        <x-icons.search-zoom/>
      </div>
    </div>
    <div class="text-style-s2">{{__('articles.noResults')}}</div>
    <div class="text-size-small text-weight-medium text-color-grey">{{__('articles.noResultTxt')}}</div>
  </div>
</div>
<!-- /NOT FOUND -->
§
