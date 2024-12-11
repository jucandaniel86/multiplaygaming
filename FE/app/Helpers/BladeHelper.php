<?php

  namespace App\Helpers;

  class BladeHelper
  {
    static function shapeSpace_add_var($url, $mod)
    {
      $purl = parse_url($url);

      $params = array();

      if (($query_str = $purl['query'])) {
        parse_str($query_str, $params);

        foreach ($params as $name => $value) {
          if (isset($mod[$name])) {
            $params[$name] = $mod[$name];
            unset($mod[$name]);
          }
        }
      }

      $params = array_merge($params, $mod);

      $ret = "";

      if ($purl['scheme']) {
        $ret = $purl['scheme'] . "://";
      }

      if ($purl['host']) {
        $ret .= $purl['host'];
      }

      if ($purl['path']) {
        $ret .= $purl['path'];
      }

      if ($params) {
        $ret .= '?' . http_build_query($params);
      }


      return $ret;
    }

    static function generateDemoURL($game_demo_url)
    {
      $generateRandom = "loadtest" . rand(1000, 10000);
      return self::shapeSpace_add_var($game_demo_url, ['playToken' => $generateRandom]);
    }
  }
