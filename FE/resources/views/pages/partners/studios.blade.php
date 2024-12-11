@extends('layouts.website')
@section('content')
    @include('components._page-header', [
       'title' => __('partners.studios.title'),
       'text' => __('partners.studios.hero_txt'),
       'button' => [
         'route' => 'fe.contact',
         'label' => __('partners.studios.partnerBtn'),
         'class' => ''
       ],
       'background' => 'background-color-primary',
       'textColor' => ''
     ])

    @include('components._content-image', [
     'title' => __('partners.studios.about1SpinTitle'),
     'text1' => __('partners.studios.about1SpinText1'),
     'text2' => __('partners.studios.about1SpinText1'),
     'button' => [
            'label' => __('partners.studios.partnerBtn'),
        'route' => 'fe.contact'
      ],
      "image" => "assets/imgs/joystick.png"
    ])

    @include('components._content-image', [
     'title' => __('partners.studios.program_title'),
     'text1' => __('partners.studios.program_text'),
     'text2' => '',
     'textLeft' => false,
     'image' => 'assets/imgs/who_is_the_program_for.jpg'
    ])
    <section>
        <style>
          .partners__item_normal {
            background: #649fe0 !important;
            display: flex;
            height: 100%;
            width: 100%;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            border-radius: .75rem;
            overflow: hidden;
          }

          .partnership-benefit h3 {
            font-size: 1.85rem;
          }

          .partnership-benefit figcaption span {
            font-size: 1rem;
            text-align: justify;
          }

          .partners__item_normal h3 {
            text-align: center;
          }

          .parntners__item {
            min-height: 300px;
          }

          .partnership-benefit figcaption {
            top: 100%;
            display: flex;
            justify-content: center;
            align-content: center;
            background: #213786 !important;
            opacity: 1 !important;
            overflow: hidden;
            border-radius: .75rem;
          }

          .partnership-benefit figcaption span {
            height: 100%;
          }

          /*.parntners__item {*/
          /*  background: #649fe0 !important;*/
          /*  !*background: linear-gradient(180deg, rgba(161, 234, 253, 1) 0%, rgba(100, 159, 224, 1) 51%, rgba(24, 39, 108, 1) 100%);*!*/
          /*  color: #fff !important;*/
          /*  display: flex;*/
          /*  align-items: center;*/
          /*  flex-direction: column;*/
          /*  border-radius: .75rem;*/
          /*  padding: 1rem;*/
          /*  justify-content: center;*/
          /*  min-height: 300px;*/
          /*}*/

          /*.parntners__item > p {*/
          /*  color: #fff;*/
          /*  display: none;*/
          /*}*/

          /*.parntners__item h3 {*/
          /*  text-align: center;*/
          /*}*/

          /*.parntners__container {*/
          /*  gap: .5rem;*/
          /*}*/

          /*@media (min-width: 1200px) {*/
          /*  .parntners__item {*/
          /*    flex: 0 0 32.333333%;*/
          /*    max-width: 33.333333%;*/
          /*  }*/
          /*}*/
        </style>
        <div class="padding-global">
            <div class="container-large">
                <div class="padding-section-large mobile-medium">
                    <h3 class="text-center">{{ __('partners.studios.partners_services_title') }}</h3>
                    <div class="parntners__container">
                        @foreach(__('partners.studios.partners_services') as $service)
                            <div class="parntners__item">
                                <figure class="partnership-benefit">
                                    <div class="partners__item_normal">
                                        <h3>{{$service['title']}}</h3>
                                    </div>
                                    <figcaption>
                                        <span>{!! $service['text'] !!}</span>
                                    </figcaption>
                                </figure>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($partners) && count($partners))
        <section class="section_titles">
            <div class="padding-global">
                <div class="container-large">
                    <div class="padding-section-medium">
                        <div class="padding-bottom padding-small">
                            <h2 class="heading-style-h3">{{ __('partners.studios.partnersTitles') }}</h2>
                        </div>
                        <div class="padding-bottom padding-small">
                            <div class="component_title" style="align-items: center;">
                                @foreach($partners as $key => $partner)
                                    <img
                                            src="{{ asset('uploads/partners/' . $partner->logo) }}"
                                            class="img_title"
                                            loading="lazy"
                                            style="max-height: 200px; object-fit: contain; {{ $key === 0 ? 'grid-area: Area;' : 'grid-area: span 1/span 1/span 1/span 1' }}"
                                            title="{{ $partner->name }}"/>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @include('components._cta')
@endsection