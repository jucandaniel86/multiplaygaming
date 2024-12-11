@extends('layouts.website')
@section('content')
  @include('components._page-header', [
    'title' => __('partners.clients.title'),
    'text' => __('partners.clients.hero_txt'),
    'button' => [
      'route' => 'fe.contact',
      'label' => __('marketing.tools.offerBtn'),
      'class' => ''
    ],
    'background' => 'background-color-primary',
    'textColor' => ''
  ])

  @include('components._content-image', [
    'title' => __('partners.clients.whyUsTitle'),
    'list' => __('partners.clients.benefits'),
    'button' => [
			'route' => 'fe.contact',
			'label' => __('partners.clients.customizeOffer')
    ],
    'image' => 'assets/imgs/our_partners_clients.png'
  ])

  @includeWhen(isset($xys), 'components._work')

  @includeWhen(isset($xsy), 'components._tools', [
    'title' => __('partners.partenersItemsTitle'),
    'list' => __('partners.partnersItemsList')
  ])

  @include('components._cta')
@endsection
