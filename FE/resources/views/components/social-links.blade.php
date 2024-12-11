<div class="{{ isset($class) ? $class : 'wrapper_social-links' }}">
  @foreach(config('website.social_links') as $social)
    <a
      href="{{ $social['link'] }}"
      target="_blank"
      title="{{ 'Follow ' . env('APP_NAME') . ' on ' . ucfirst($social['id']) }}"
      class="icon_wrap-social w-inline-block">
      <div class="icon_social w-embed">
        <img
          alt="{{ 'Follow ' . env('APP_NAME') . ' on ' . ucfirst($social['id']) }}"
          src="{{ asset('assets/imgs/icons/'.$social['id'].'.svg') }}"
        />
      </div>
    </a>
  @endforeach
</div>
<style>
  .wrapper_social-links img {
    width: 1.25rem;
    height: 1.25rem;
  }
</style>
