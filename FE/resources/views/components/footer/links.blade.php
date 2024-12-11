<div class="wrapper_footer-top d-grid">
  @foreach($footer as $item)
    <div class="link-list_footer">
      <div class="footer_column-heading padding-bottom">{{ $item['label'] }}</div>
      @foreach($item['childs'] as $child)
        <a
          title="{{ $child['label'] }}"
          href="{{ $child['url'] }}"
          class="link_footer">{{ $child['label'] }}</a>
      @endforeach
    </div>
  @endforeach
</div>
