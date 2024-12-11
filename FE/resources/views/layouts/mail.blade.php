<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="und">
<head>
  <meta http-equiv="Content-Security-Policy"
        content="script-src 'none'; connect-src 'none'; object-src 'none'; form-action https://cdn.ampproject.org https://amp.stripo.email;">
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <meta name="x-apple-disable-message-reformatting">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="telephone=no" name="format-detection">
  <title>{{ isset($title) ? $title : env('APP_NAME') }}</title><!--[if (mso 16)]>
  <style type="text/css">
  a {
    text-decoration: none;
  }
  </style>
  <![endif]--><!--[if gte mso 9]>
  <style>sup {
    font-size: 100% !important;
  }</style><![endif]--><!--[if gte mso 9]>
  <xml>
  <o:OfficeDocumentSettings>
    <o:AllowPNG></o:AllowPNG>
    <o:PixelsPerInch>96</o:PixelsPerInch>
  </o:OfficeDocumentSettings>
  </xml>
  <![endif]--><!--[if !mso]><!-- -->
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&amp;display=swap" rel="stylesheet">
  <!--<![endif]-->
  <style>{!! \File::get(public_path('/assets/css/email.css'))!!}</style>
  <base href="#">
</head>
<body
  style="width:100%;font-family:'Josefin Sans', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
<div dir="ltr" class="es-wrapper-color" lang="und" style="background-color:#b8eefe"><!--[if gte mso 9]>
  <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
  <v:fill type="tile" color="#e8f1ce"></v:fill>
  </v:background>
  <![endif]-->
  <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" role="none"
         style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top;background-color:#b8eefe">
    <tbody>
    <tr>
      <td valign="top" style="padding:0;Margin:0">
        <table class="es-header" cellspacing="0" cellpadding="0" align="center" role="none"
               style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
          <tbody>
          <tr>
            <td align="center" style="padding:0;Margin:0">
              <table class="es-header-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
                     align="center" role="none"
                     style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                <tbody>
                <tr>
                  <td align="left"
                      style="padding:0;Margin:0;padding-top:20px;padding-left:20px;padding-right:20px">
                    <table cellspacing="0" cellpadding="0" width="100%" role="none"
                           style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                      <tbody>
                      <tr>
                        <td class="es-m-p0r" valign="top" align="center"
                            style="padding:0;Margin:0;width:560px">
                          <table width="100%" cellspacing="0" cellpadding="0"
                                 role="presentation"
                                 style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                              <td align="center" style="padding:0;Margin:0;font-size:0px">
                                <a target="_blank" href="{{ url('/') }}"
                                   style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#333333;font-size:14px"><img
                                    src="{{ asset('assets/imgs/logo.png') }}"
                                    alt="Logo"
                                    style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"
                                    height="50" title="Logo"></a></td>
                            </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                </tbody>
              </table>
            </td>
          </tr>
          </tbody>
        </table>
        <table class="es-content" cellspacing="0" cellpadding="0" align="center" role="none"
               style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
          <tbody>
          <tr>
            <td align="center" style="padding:0;Margin:0">
              <table class="es-content-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
                     align="center" role="none"
                     style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                <tbody>
                <tr>
                  <td align="left" style="padding:20px;Margin:0">
                    <table width="100%" cellspacing="0" cellpadding="0" role="none"
                           style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                      <tbody>
                      <tr>
                        <td class="es-m-p0r es-m-p20b" valign="top" align="center"
                            style="padding:0;Margin:0;width:560px">
                          @yield('content')
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                </tbody>
              </table>
            </td>
          </tr>
          </tbody>
        </table>
        <table class="es-footer" cellspacing="0" cellpadding="0" align="center" role="none"
               style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
          <tbody>
          <tr>
            <td align="center" style="padding:0;Margin:0">
              <table class="es-footer-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
                     align="center" role="none"
                     style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#66a6e1;width:600px">
                <tbody>
                <tr>
                  <td align="left"
                      style="Margin:0;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:20px">
                    <table cellspacing="0" cellpadding="0" width="100%" role="none"
                           style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                      <tbody>
                      <tr>
                        <td align="left" style="padding:0;Margin:0;width:560px">
                          <table width="100%" cellspacing="0" cellpadding="0"
                                 role="presentation"
                                 style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                            <tbody>
                            <tr>
                              <td align="center" class="es-infoblock made_with"
                                  style="padding:0;Margin:0;line-height:14px;font-size:0;color:#CCCCCC">
                                <a target="_blank"
                                   href="#"
                                   style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#CCCCCC;font-size:12px"><img
                                    src="{{ asset('assets/imgs/logo.png') }}"
                                    alt="" width="125"
                                    style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic"></a>
                              </td>
                            </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                </tbody>
              </table>
            </td>
          </tr>
          </tbody>
        </table>
      </td>
    </tr>
    </tbody>
  </table>
</div>

</body>
</html>
