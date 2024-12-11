@extends('layouts.website')
@section('content')
  @include('components._page-header', [
  'title' => __('marketing.tools.title'),
  'text' => __('marketing.tools.hero_txt'),
  'button' => [
    'route' => 'fe.contact',
    'label' => __('marketing.tools.offerBtn'),
    'class' => 'button w-button'
  ]
  ])

  @include('components._features', [ 'features' => __('marketing.tools.features')])

  @include('components._content-image', [
	  'title' => __('marketing.tools.freeSpins'),
	  'text1' => __('marketing.tools.freeSpinsTxt'),
	  'text2' => __('marketing.tools.freeSpinsTxt2'),
	  'list' => __('marketing.tools.freeSpinsList'),
	  'image' => 'assets/imgs/free_spins.png'
  ])

  @include('components._content-image', [
    'title' => __('marketing.tools.jackpotsTitle'),
    'text1' => __('marketing.tools.jackpotsText'),
    'text2' => __('marketing.tools.jackpotsText2'),
    'list' => __('marketing.tools.jackpotsList'),
    'textLeft' => false,
    'image' => 'assets/imgs/progressive_jackpots.png'
  ])

  @include('components._content-image', [
  'title' => __('marketing.tools.cashRaceTitle'),
  'text1' => __('marketing.tools.cashRaceText1'),
  'text2' => __('marketing.tools.cashRaceText2'),
  'list' => [],
  'image' => 'assets/imgs/cash_race.png'
])

  @include('components._content-image', [
   'title' => __('marketing.tools.promotionsTitle'),
   'text1' => __('marketing.tools.promotionsText1'),
   'text2' => __('marketing.tools.promotionsText2'),
   'list' => [],
   'textLeft' => false,
   'image' => 'assets/imgs/bespoke-promotions.jpg'
 ])

  <x-partners/>

  @include('components._tools', [
	  'title' => __('marketing.tools.toolsTitle'),
	  'list' => __('marketing.tools.toolsList')
  ])
  @include('components._cta')
@endsection
