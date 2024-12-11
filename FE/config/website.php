<?php
	return [
		'website_menu' => [
			[
				"label" => "menu.games",
				"route" => "fe.games",
				"childs" => [],
				"icon" => false,
			],
			[
				"label" => "menu.engagement_solutions",
				"route" => false,
				"icon" => false,
				"childs" => [
					[
						"icon" => "ranking.svg",
						"route" => 'fe.marketing.tools',
						"label" => "menu.marketing_solutions"
					],
					[
						"label" => "menu.tailored_experiences",
						"route" => 'fe.marketing.brandsExclusive',
						"icon" => "crown.svg"
					],
					[
						"icon" => "clipboard.svg",
						"route" => 'fe.marketing.gameSetsPromo',
						"label" => "menu.game_promo"
					],
				]
			],
			[
				"label" => "menu.partners",
				"route" => false,
				"icon" => false,
				"childs" => [
					[
						"icon" => "user-profile.svg",
						"route" => 'fe.partners.clients',
						"label" => "menu.clients"
					],
					[
						"icon" => "studios.svg",
						"route" => 'fe.partners.studios',
						"label" => "menu.studios"
					],
				]
			],
			[
				"label" => "menu.blog",
				"route" => false,
				"icon" => false,
				"childs" => [
					[
						"icon" => "news.svg",
						"route" => 'fe.articles.news',
						"label" => "menu.news"
					],
					[
						"icon" => "articles.svg",
						"route" => 'fe.articles',
						"label" => "menu.articles"
					],
				]
			],
			[
				"label" => "menu.about",
				"route" => false,
				"icon" => false,
				"childs" => [
					[
						"icon" => "main-component.svg",
						"route" => 'fe.about.company',
						"label" => "menu.company"
					],
					[
						"icon" => "career.svg",
						"route" => 'fe.about.careers',
						"label" => "menu.careers"
					],
//          [
//            "icon" => "medal.svg",
//            "route" => 'fe.about.responsibleGaming',
//            "label" => "Responsible Gaming"
//          ],
				]
			]
		],
		"partners" => [
			[
				"link" => "https://stake.com/",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/640de69e9e7c8b467a87dca3_Stake.svg"
			],
			[
				"link" => "https://www.pin-up.casino/ru-ru/bgaming",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/64466e596a96a73ad21a7122_pin-up_dark.svg"
			],
			[
				"link" => "https://blaze.com/",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/64004fc2e9174ab29c4ec6f6_blaze_dark.svg"
			],
			[
				"link" => "https://roobet.com/",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/640052f1917ae5eaf28ac56d_roobet_dark.svg"
			],
			[
				"link" => "https://gamdom.com/",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/640de7a7142ac1e953ae5521_Gamdom.svg"
			],
			[
				"link" => "https://www.bitstarz.com/games/bgaming",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/64004f81b6cf0019d7e273b6_bit_starz_dark.svg"
			],
			[
				"link" => "https://rollbit.com/",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/64005229fc02904c75eda414_rollbit_dark.svg"
			],
			[
				"link" => "https://betfury.io/casino/providers/bgaming",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/640de7faf1677570e0d2d8ce_betfury%20(2).svg"
			],
			[
				"link" => "https://roxcasino.com/",
				"img" => "https://cdn.prod.website-files.com/63b3249466615535f76d4b4e/64004aa752089382b033a5b3_rox%20casino_dark.svg"
			]
		],
		'generalSort' => [
			[
				'id' => 'release_date',
				'label' => 'Release Date',
				'default' => true,
				'default_icon' => 'arrows',
				'options' => [
					['value' => 'release_recent', 'label' => 'Recent|Oldest', 'icon' => 'down'],
					['value' => 'relase_oldest', 'label' => 'Oldest|Recent', 'icon' => 'up']
				]
			],
			[
				'id' => 'date',
				'label' => 'Date',
				'default' => true,
				'default_icon' => 'arrows',
				'options' => [
					['value' => 'date_recent', 'label' => 'Recent|Oldest', 'icon' => 'down'],
					['value' => 'date_oldest', 'label' => 'Oldest|Recent', 'icon' => 'up']
				]
			],
			[
				'id' => 'rtp',
				'label' => 'RTP',
				'default' => false,
				'default_icon' => '',
				'options' => [
					['value' => 'rtp_high', 'label' => 'High|Low', 'icon' => 'down'],
					['value' => 'rtp_low', 'label' => 'Low|Hight', 'icon' => 'up']
				]
			],
			[
				'id' => 'volatility',
				'label' => 'Volatility',
				'default' => false,
				'default_icon' => '',
				'options' => [
					['value' => 'volatility_very_high', 'label' => 'Very High|Low', 'icon' => 'down'],
					['value' => 'volatility_low', 'label' => 'Low|Very High', 'icon' => 'up']
				]
			],
			[
				'id' => 'multiplier',
				'label' => 'Max.multiplier',
				'default_icon' => '',
				'default' => false,
				'options' => [
					['value' => 'multiplier_high', 'label' => 'High|Low', 'icon' => 'down'],
					['value' => 'multiplier_low', 'label' => 'Low|High', 'icon' => 'up']
				]
			],
		],
		'paths' => [
			"games" => "/uploads/games/",
			"articles" => "/uploads/articles/",
			"partners" => "/uploads/partners/",
			"cvs" => "/uploads/cvs/",
			"downloads" => "/uploads/downloads/",
			'banners' => '/uploads/banners/',
			"assets" => '/uploads/assets/',
		],

		'social_links' => [
//      ['id' => 'facebook', 'link' => 'https://facebook.com'],
			['id' => 'linkedin', 'link' => 'https://www.linkedin.com/company/blue-jack-gaming'],
//      ['id' => 'instagram', 'link' => 'https://instagram.com'],
			['id' => 'youtube', 'link' => 'https://www.youtube.com/@BlueJackGaming'],
//      ['id' => 'twitter', 'link' => 'https://twitter.com'],
		],
		'official_email' => 'info@bluejackgaming.com',
//    'support_email' => 'sales@bluejackgaming.com',
		'support_email' => 'jucan.daniel1@gmail.com',
	];