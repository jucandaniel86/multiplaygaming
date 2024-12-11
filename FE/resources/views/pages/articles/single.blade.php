@extends('layouts.website')
@section('content')
  <section class="section_hero-article mobile-margin-small">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="padding-top padding-small">
            <div class="padding-bottom padding-xxsmall">
              <div class="wrap_img-article">
                <div class="padding-bottom padding-xxsmall">
                  <a href="{{ route('fe.articles') }}"
                     class="button is-text-icon is-small w-inline-block">
                    <div class="align-center w-embed">
                      <x-icons.arrow-left/>
                    </div>
                    <div>{{ __('articles.allArticles') }}</div>
                  </a>
                </div>
                @if($article->banner)
                  <img
                    src="{{ $article->banner }}"
                    loading="eager"
                    alt="{{ $article->title }}"
                    class="img_article hide-mobile-landscape"/>
                @endif
              </div>
            </div>
            <div class="w-layout-grid layout_article">
              <div class="component_subscribe-article" style="grid-area: video;">
                <div class="item_form-article">
                  <div class="padding-bottom padding-tiny">
                    <div class="text-style-s1">{{ __('articles.newsletterTitle') }}</div>
                  </div>
                  <div class="w-form">
                    <form
                      id="wf-form-form-sub-news"
                      method="get"
                      action="#">
                      <div class="form_field-wrapper">
                        <label for="email-2" class="form_label">{{__('articles.email')}}</label>
                        <input class="form_input is-sub w-input" maxlength="256" name="email"
                               placeholder="email@domain.com"
                               type="email"
                               id="email-2" required="">
                        <div class="hide w-embed">
                          <select name="sub_type" id="sub_type">
                            <option value="news" selected="">{{__('articles.news')}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="padding-bottom padding-xxsmall"></div>
                      <div class="button-wrap_form-contact">
                        <label class="w-checkbox form_checkbox agreement_check">
                          <div
                            class="w-checkbox-input w-checkbox-input--inputType-custom footer_checkbox-icon has-small-text"></div>
                          <input
                            type="checkbox"
                            name="Agreement"
                            id="Agreement"
                            style="opacity:0;position:absolute;z-index:-1">
                          <span
                            class="form_checkbox-label text-size-small w-form-label" for="Agreement">
                            {{__('articles.agreement')}}
                          </span>
                        </label>

                        <input
                          type="submit" data-wait="{{__('articles.pleaseWait')}}"
                          class="button color_primary data-process w-button"
                          style="display: block; margin-top: 1rem; width: 100%;"
                          value="{{__('articles.submit')}}">
                        <div class="form_message-warn">
                          <div>{{__('articles.warnMessage')}}</div>
                        </div>
                      </div>
                    </form>
                    <div class="form_message-success w-form-done" tabindex="-1" role="region">
                      <div>{{__('articles.successMessage')}}</div>
                    </div>
                    <div class="form_message-error w-form-fail" tabindex="-1" role="region">
                      <div>{{__('articles.errorMessage')}}</div>
                    </div>
                  </div>
                </div>
                <div class="wrap_social-article">
                  <div class="w-embed">
                    <a href="#" class="icon_wrap-social sub copy" onclick="copyText()">
                      <div class="icon-1x1-small sub">
                        <x-icons.copy/>
                      </div>
                    </a>
                  </div>
                  <div class="w-embed">
                    <a
                      href="#"
                      class="icon_wrap-social sub">
                      <div class="icon-1x1-small w-embed">
                        <x-icons.linkedin/>
                      </div>
                    </a>
                  </div>
                  <div class="w-embed">
                    <a
                      href=""
                      class="icon_wrap-social sub">
                      <div class="icon-1x1-small w-embed">
                        <x-icons.twitter/>
                      </div>
                    </a>
                  </div>
                  <div class="w-embed">
                    <a
                      href=""
                      class="icon_wrap-social sub">
                      <div class="icon-1x1-small w-embed">
                        <x-icons.facebook/>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              <article class="component_body-position" style="grid-area: text;">
                <div class="heading_body-position" style="grid-area: span 1/span 1/span 1/span 1">
                  <div class="padding-bottom padding-tiny">
                    <div class="wrap_article-data">
                      @if($article->category)
                        <div class="label is-gray">
                          <div>{{ $article->category->name }}</div>
                        </div>
                      @endif
                      <div class="text-size-regular">
                        {{ $article->published_date ?
                              Carbon\Carbon::parse($article->published_date)->format("M d, Y") :
                              Carbon\Carbon::parse($article->updated_at)->format("M d, Y")
                        }}
                      </div>
                    </div>
                  </div>
                  <h1 class="heading-style-h4">{{ $article->title }}</h1></div>
                <div class="text-rich-text w-richtext">
                  {!! $article->content !!}
                </div>
              </article>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @if($relatedArticles)
    <x-more-articles
      :title="__('global.articleAlike')"
      :articles="$relatedArticles"
    />
  @endif
@endsection
