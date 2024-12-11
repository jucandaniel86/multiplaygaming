@extends('layouts.website')
@section('content')
  @include('components._page-header', [
    'title' => __('marketing.brand.title'),
    'text' => __('marketing.brand.hero_txt'),
    'button' => [
      'route' => 'fe.contact',
      'label' => __('marketing.tools.offerBtn'),
      'class' => 'button w-button'
  ]
  ])

  @include('components._content-image', [
    'title' => __('marketing.brand.brandedTitle'),
    'text1' => __('marketing.brand.brandedText'),
    'text2' => __('marketing.brand.brandedText2'),
    'list' => [],
    'button' => [
			'label' => __('marketing.brand.getMoreInfo')
    ],
    "image" => 'assets/imgs/custom-branded-games.jpg'
  ])

  @include('components._weeks', [
	  'title' => __('marketing.brand.campaignsTitle'),
	  'text' => __('marketing.brand.campaignsText'),
	  'button' => [
			'label' => __('marketing.brand.getMoreInfo'),
    ],
    'image' => 'assets/imgs/exclusive_marketing.jpg'
  ])

  <x-featured-games :title="__('global.featured_games_title')"/>

  <x-scrolled-component
    :title="__('marketing.brand.lvlCustomizationTitle')"
    :text="__('marketing.brand.lvlCustomizationTxt')"
    :button="['label' => __('marketing.brand.lvlCustomizationCTA') ]">

    <div class="item_levels">
      <div>
        <div class="margin-bottom margin-tiny">
          <img src="{{ asset('assets/imgs/customized_content.png') }}" loading="lazy" class="img_levels"/>
          <h3 class="heading-style-h5 _2" style="margin-top:.5rem;">Customized Content</h3>
        </div>
        <div class="text-size-medium">
          Personalize Bluejack Gaming slots based on your strategic requests, including unique logos or custom symbols,
          and tailored start pages. Strengthen your brand, engage players effectively, and select your preferred RTP for
          a balance of profitability and player satisfaction, enhancing overall game appeal.
        </div>
      </div>
    </div><!-- /.item_levels -->

    <div class="item_levels">
      <div>
        <div class="margin-bottom margin-tiny">
          <img src="{{ asset('assets/imgs/enhanced_customization.jpg') }}" loading="lazy" class="img_levels"/>
          <h3 class="heading-style-h5 _2" style="margin-top:.5rem;">Enhanced Customization</h3>
        </div>
        <div class="text-size-medium">
          Transform Bluejack Gaming slots with custom layouts, unique animations, and tailored RTP settings. Create a
          special connection with players, boost their satisfaction, and enhance game popularity through strategic
          visual designs and big win pop-ups.
        </div>
      </div>
    </div><!-- /.item_levels -->

    <div class="item_levels">
      <div>
        <div class="margin-bottom margin-tiny">
          <img src="{{ asset('assets/imgs/exclusive-customization.png') }}" loading="lazy" class="img_levels"/>
          <h3 class="heading-style-h5 _2" style="margin-top:.5rem;">Exclusive Customization</h3>
        </div>
        <div class="text-size-medium">
          Have a fully reskinned game on any Bluejack Gaming engines with a unique name and tailored RTP. This exclusive
          game will feature custom designs and animations, perfectly aligned with your profitable game themes and
          mechanics.

        </div>
      </div>
    </div><!-- /.item_levels -->

    <div class="item_levels">
      <div>
        <div class="margin-bottom margin-tiny">
          <img src="{{ asset('assets/imgs/bespoke_game.jpg') }}" loading="lazy" class="img_levels"/>
          <h3 class="heading-style-h5 _2" style="margin-top:.5rem;">Bespoke Game</h3>
        </div>
        <div class="text-size-medium">
          Bluejack Gaming offers fully bespoke games, developing custom graphics, mechanics, RTP, and game features from
          scratch. Whether it is a single or multiple unique features, we tailor every aspect to your specifications,
          delivering a completely original gaming experience for your players.

        </div>
      </div>
    </div><!-- /.item_levels -->

  </x-scrolled-component>

  <x-partners/>

  @include('components._tools', [
   'title' => __('marketing.tools.toolsTitle'),
   'list' => __('marketing.tools.toolsList')
  ])
  @include('components._cta')
@endsection
