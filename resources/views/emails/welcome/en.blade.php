<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <style type="text/css">
        td{
            text-align: justify;
        }
    </style>
</head>
<body style="color: #384047;font-family: Arial;margin:0;font-size: 16px;">
    <table cellpadding="0" cellspacing="0" align="center" style="border-spacing: 0; width: 100%; max-width: 740px; padding: 0 20px;">
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0"  width="100%" align="center">
                    <tr>
                        <td height="30"></td>
                    </tr>
                    <tr>
                        <td style="font-family: Arial;margin: 0 ;padding: 0;font-size: 24px;line-height: 18px;color: #fff;">
                            <a style="color: #00ab6b;text-decoration: inherit;font-weight: bold;" href="http://antoree.com">
                                <img src="http://www.antoree.com/public/images/email_logo1.png" alt="">
                            </a>
                        </td>
                        <td style="text-align: right;">
                            Learn english online one-on-one
                        </td>
                    </tr>
                    <tr>
                        <td height="10" style="height: 10px;"></td>
                    </tr>
                    <tr>
                        <td height="4" width="100%" colspan="2" style="background-color: #00ab6b; height: 4px; width: 100%;"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" align="justify" style="color: #384047; margin: 0 auto;">
                    <tr height="30">
                        <td></td>
                    </tr>
                    <tr>
                        <td>Hello {{ $name }},</td>
                    </tr>
                    <tr height="20">
                        <td></td>
                    </tr>
                    <tr>
                        <td>Thank you for registering on antoree.com</td>
                    </tr>
                    <tr height="20">
                        <td></td>
                    </tr>
                    <tr>
                        <td style="line-height: 22px;">
                            Please click the button below or use the following copy paste link to confirm this email address:<br>
                            <a href="{{ $url_confirm }}" style="color: #00ab6b; text-decoration: none;font-weight: 600; font-size: 16px;">{{ $url_confirm }}</a>

                        </td>
                    </tr>
                    <tr height="40">
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                        <a href="{{ $url_confirm }}" style="background-color: #00ab6b;color: #fff;text-align: center;padding: 16px;border: none;font-weight: 600;cursor: pointer;font-size: 16px; width: 150px;display: block;text-decoration: none;">CONFIRM</a>
                        </td>
                    </tr>
                    <tr height="50">
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <hr style="background: #eee;height: 1px;border: none;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" align="center">
                    <tr>
                        <td>

                            <table width="100%" align="center">
                                <tr>
                                    <td style="color: rgba(56, 64, 71, 0.6); font-size: 12px;line-height: 16px;">
                                        <strong style="color: rgba(56, 64, 71, 0.8); font-size: 14px; font-weight: 600;">Antoree International Pte. Ltd.</strong><br>
                                        <span>Hanoi Office: 10/220 Bach Mai,Hai Ba Trung, Hanoi</span><br>
                                        <span>Singapore head office: 10 Anson Road # 26-04,International Plaza, Singapore 079903</span>
                                    </td>
                                    <td style="text-align: right; vertical-align: middle;">
                                        <a href="https://www.facebook.com/antoree.global" style="text-decoration: none; margin: 0 3px;">
                                            <img src="http://www.antoree.com/public/images/email_facebook.png" alt="" style="width: 30px; height: 30px;">
                                        </a>
                                        <a href="https://www.instagram.com/antoree.cc/" style="text-decoration: none; margin: 0 3px;">
                                            <img src="http://www.antoree.com/public/images/email_instagram.png" alt="" style="width: 30px; height: 30px;">
                                        </a>
                                        <a href="https://www.youtube.com/channel/UCFFoOzIv-jDYUNfrgx4KRkA" style="text-decoration: none; margin: 0 3px;">
                                            <img src="http://www.antoree.com/public/images/email_youtube.png" alt="" style="width: 30px; height: 30px;">
                                        </a>
                                        <a href="skype:antoree.cc8?chat" style="text-decoration: none; margin: 0 3px;">
                                            <img src="http://www.antoree.com/public/images/email_skype.png" alt="" style="width: 30px; height: 30px;">
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="75" style="height: 75px;"></td>
        </tr>
    </table>
</body>
</html>
