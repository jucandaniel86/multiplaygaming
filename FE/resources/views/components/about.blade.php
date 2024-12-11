<section class="section_about-us padding-global">
  <div class="container-large padding-section-medium">
    <div class="component_about-us">
      @if(isset($image))
        <div class="wrap-img_about-us" style="
        will-change: transform;
        transform: translate3d(0px, -3rem, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg);
        transform-style: preserve-3d;">
          <img class="img_about-us paralax" src="{{ $image }}"/>
        </div>
      @endif
      <div class="wrap-text_about-us">
        <div class="margin-bottom margin-medium w-embed">
          <img src="{{ asset('assets/imgs/logo_portrait.png') }}" style="width: 4rem; height: 4.75rem;"/>
        </div>
        <div class="heading_about-us padding-bottom padding-medium">
          @if(isset($title))
            <h1 class="heading-style-h1">{{ $title }}</h1>
            <div class="padding-bottom padding-tiny"></div>
          @endif
          @if(isset($text))
            <p class="text-size-medium text-weight-medium max-width-small">{{ $text }}</p>
          @endif
        </div>
        <a
          class="button is-text-arrow w-inline-block"
          style="background: none !important;"
          href="{{ route('fe.about.company') }}">
          <div>{{__('global.aboutUs')}}</div>
          <div class="icon_button-text w-embed">
            <x-icons.arrow-right/>
          </div>

        </a>
      </div>
    </div>
  </div>
</section>
