<?php

  namespace App\Http\Controllers;

  use App\Models\GameCategory;
  use Illuminate\Support\Facades\File;
  use luizbills\CSS_Generator\Generator as CSS_Generator;

  class BaseController extends Controller
  {
    protected CSS_Generator $css;

    public function __construct()
    {
      #css
      $options = [];
      $this->css = new CSS_Generator($options);
      foreach (config('css.default_css') as $css) {
        $this->css->add_raw(File::get(public_path('/assets/' . $css)));
      }

      #footer
      $footer = [
        [
          "label" => "Game Titles",
          'id' => 'games',
          'childs' => []
        ],
        [
          "label" => "Engagement Solutions",
          'id' => 'marketing',
          'childs' => []
        ],
        [
          "label" => "Our Partners",
          'id' => 'partners',
          "childs" => []
        ],
        [
          "label" => __('global.quickLink'),
          'id' => 'quickLinks',
          'childs' => []
        ],
        [
          "label" => __('global.company'),
          'id' => 'company',
          'childs' => []
        ]
      ];

      $gameCategories = GameCategory::query()->where('DELETED', 0)->get();

      foreach ($footer as &$links) {
        switch ($links['id']) {
          case 'games':
            {
              foreach ($gameCategories as $gameCategory) {
                $links['childs'][] = [
                  'label' => $gameCategory->name,
                  'url' => route('fe.games.game_type', ['slug' => $gameCategory->slug])
                ];
              }
            }
            break;
          case 'marketing':
            {
              $links['childs'][] = [
                'label' => "Marketing Solutions",
                'url' => route('fe.marketing.tools')
              ];
              $links['childs'][] = [
                'label' => "Tailored Experiences",
                'url' => route('fe.marketing.brandsExclusive')
              ];
              $links['childs'][] = [
                'label' => "Game Promo",
                'url' => route('fe.marketing.gameSetsPromo')
              ];
            }
            break;
          case 'partners':
            {
              $links['childs'][] = [
                'label' => __('global.clients'),
                'url' => route('fe.partners.clients')
              ];
              $links['childs'][] = [
                'label' => __('global.studios'),
                'url' => route('fe.partners.studios')
              ];
            }
            break;
          case 'quickLinks':
            {
              $links['childs'][] = [
                'label' => __('global.news'),
                'url' => route('fe.articles.news')
              ];
              $links['childs'][] = [
                'label' => __('global.articles'),
                'url' => route('fe.articles')
              ];
              $links['childs'][] = [
                'label' => __('global.clientArea'),
                'url' => route('fe.clientArea')
              ];
              $links['childs'][] = [
                'label' => __('global.contactUs'),
                'url' => route('fe.contact')
              ];
            }
            break;
          case 'company':
            {
              $links['childs'][] = [
                'label' => __('global.aboutUs'),
                'url' => route('fe.about.company')
              ];
              $links['childs'][] = [
                'label' => __('global.careers'),
                'url' => route('fe.about.careers')
              ];
            }
            break;
        }
      }

      view()->share(['footer' => $footer]);
      view()->share(['css' => $this->css]);
    }

  }
