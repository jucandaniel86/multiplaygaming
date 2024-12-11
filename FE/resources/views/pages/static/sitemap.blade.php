@extends('layouts.website')
@section('content')
  <section class="section_block-hero">
    <div class="padding-global">
      <div class="container-large">
        <div class="padding-section-small">
          <div class="padding-top">
            <div class="margin-bottom margin-medium">
              <div class="heading-style-h3">Sitemap</div>
            </div>

            <!-- SITEMAP SECTION -->
            <!-- 1. GAMES -->
            @if(count($games))
              <div class="margin-bottom margin-medium">
                <div class="w-layout-grid wrapper_sitemap-games">
                  <div class="padding-bottom padding-xxsmall">
                    <div class="footer6_column-heading margin-bottom">{{__('global.games')}}</div>
                  </div>
                  <div role="list" class="list_games-sitemap">
                    @foreach($games as $game)
                      <div role="listitem">
                        <a
                          href="{{ route('fe.games.single', ['slug' => $game->slug]) }}"
                          title="{{ $game->game_name }}"
                          class="link_footer">
                          {{ $game->game_name }}
                        </a>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endif
          <!-- END 1. GAMES -->

            <!-- 2. GAMES TYPES -->
            @if(count($gameCategories))
              <div class="margin-bottom margin-medium">
                <div class="w-layout-grid wrapper_sitemap-games">
                  <div class="padding-bottom padding-xxsmall">
                    <div class="footer6_column-heading margin-bottom">{{__('global.gamesType')}}</div>
                  </div>
                  <div role="list" class="list_games-sitemap">
                    @foreach($gameCategories as $category)
                      <div role="listitem">
                        <a
                          href="{{ route('fe.games.game_type', ['slug' => $category->slug]) }}"
                          title="{{ $category->label }}"
                          class="link_footer">
                          {{ $category->label }}
                        </a>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endif
          <!-- END 2. GAMES -->

            <!-- 3. NEWS -->
            @if(count($articles))
              <div class="margin-bottom margin-medium">
                <div class="w-layout-grid wrapper_sitemap-news ">
                  <div class="padding-bottom padding-xxsmall">
                    <div class="footer6_column-heading margin-bottom">{{__('global.news')}}</div>
                  </div>
                  <div role="list" class="list_news-sitemap">
                    @foreach($articles as $article)
                      <div role="listitem">
                        <a
                          href="{{ route('fe.articles.single', ['slug' => $article->slug, 'id' => $article->id]) }}"
                          title="{{ $article->title }}"
                          class="link_footer">
                          {{ $article->title }}
                        </a>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
            @endif
          <!-- END 3. NEWS -->

            <!-- 4. CAREERS -->
            @if(count($career))
              <div class="margin-bottom margin-medium">
                <div class="w-layout-grid wrapper_sitemap-games">
                  <div class="padding-bottom padding-xxsmall">
                    <div class="footer6_column-heading margin-bottom">{{__('global.careers')}}</div>
                  </div>
                  <div class="collection_game-sitemap">
                    <div role="list" class="list_games-sitemap">
                      @foreach($career as $job)
                        <div role="listitem">
                          <a
                            href="{{ route('fe.careers.single', ['slug' => $job->slug, 'id' => $job->id]) }}"
                            title="{{ $job->job_title }}"
                            class="link_footer">
                            {{ $job->job_title }}
                          </a>
                        </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
          @endif
          <!-- END 4. CAREERS -->

            <!-- 5. MARKETING -->
            <div class="margin-bottom margin-medium">
              <div class="w-layout-grid wrapper_sitemap-games">
                <div class="padding-bottom padding-xxsmall">
                  <div class="footer6_column-heading margin-bottom">{{__('global.marketing')}}</div>
                </div>
                <div role="list" class="list_games-sitemap">
                  @foreach($marketing as $item)
                    <div role="listitem">
                      <a
                        href="{{ route($item['route']) }}"
                        title="{{ $item['label'] }}"
                        class="link_footer">
                        {{ $item['label'] }}
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <!-- END 5. MARKETING -->

            <!-- 6. PARTNERS -->
            <div class="margin-bottom margin-medium">
              <div class="w-layout-grid wrapper_sitemap-games">
                <div class="padding-bottom padding-xxsmall">
                  <div class="footer6_column-heading margin-bottom">{{__('global.partners')}}</div>
                </div>
                <div role="list" class="list_games-sitemap">
                  @foreach($partners as $item)
                    <div role="listitem">
                      <a
                        href="{{ route($item['route']) }}"
                        title="{{ $item['label'] }}"
                        class="link_footer">
                        {{ $item['label'] }}
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <!-- END 6. PARTNERS -->

            <!-- 7. COMPANY -->
            <div class="margin-bottom margin-medium">
              <div class="w-layout-grid wrapper_sitemap-games">
                <div class="padding-bottom padding-xxsmall">
                  <div class="footer6_column-heading margin-bottom">{{__('global.company')}}</div>
                </div>
                <div role="list" class="list_games-sitemap">
                  @foreach($company as $item)
                    <div role="listitem">
                      <a
                        href="{{ route($item['route']) }}"
                        title="{{ $item['label'] }}"
                        class="link_footer">
                        {{ $item['label'] }}
                      </a>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
            <!-- END 7. COMPANY -->
            <!-- END SITEMAP SECTION -->
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
