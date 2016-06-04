<?php

namespace Antoree\Models\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class MailHelper
{
    const EMAIL_FROM = 'x_email_from';
    const EMAIL_FROM_NAME = 'x_email_from_name';
    const EMAIL_SUBJECT = 'x_email_subject';
    const EMAIL_TO = 'x_email_to';
    const EMAIL_TO_NAME = 'x_email_to_name';

    public static function sendTemplate($template_path, $data, $locale = null)
    {
        if (!isset($data[self::EMAIL_FROM])) {
            $data[self::EMAIL_FROM] = appEmail();
        }
        if (!isset($data[self::EMAIL_FROM_NAME])) {
            $data[self::EMAIL_FROM_NAME] = appName();
        }
        if (!isset($data[self::EMAIL_SUBJECT])) {
            $data[self::EMAIL_SUBJECT] = trans('label.a_message_from') . appName();
        }
        if (!isset($data[self::EMAIL_TO])) {
            return false;
        }
        if (!empty($locale)) {
            $data['site_locale'] = $locale;
        }
        $locale = $data['site_locale'];

        try {

            Mail::queue('emails.' . $template_path . '.' . $locale, $data, function ($message) use ($data) {
                $message->from($data[MailHelper::EMAIL_FROM], $data[MailHelper::EMAIL_FROM_NAME]);
                $message->subject($data[MailHelper::EMAIL_SUBJECT]);
                if (isset($data[MailHelper::EMAIL_TO_NAME])) {
                    $message->to($data[MailHelper::EMAIL_TO]);
                } else {
                    $message->to($data[MailHelper::EMAIL_TO], $data[MailHelper::EMAIL_TO_NAME]);
                }
            });

            return count(Mail::failures()) > 0;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function sendTemplateNomal($template_path, $data, $locale = null)
    {
        if (!isset($data[self::EMAIL_FROM])) {
            $data[self::EMAIL_FROM] = appEmail();
        }
        if (!isset($data[self::EMAIL_FROM_NAME])) {
            $data[self::EMAIL_FROM_NAME] = appName();
        }
        if (!isset($data[self::EMAIL_SUBJECT])) {
            $data[self::EMAIL_SUBJECT] = trans('label.a_message_from') . appName();
        }
        if (!isset($data[self::EMAIL_TO])) {
            return false;
        }
        if (!empty($locale)) {
            $data['site_locale'] = $locale;
        }
        $locale = $data['site_locale'];
        
        try {
            Mail::queue('emails.' . $template_path . '.' . $locale, $data, function ($message) use ($data) {
                $message->from($data[MailHelper::EMAIL_FROM], $data[MailHelper::EMAIL_FROM_NAME]);
                $message->subject($data[MailHelper::EMAIL_SUBJECT]);
                if (isset($data[MailHelper::EMAIL_TO_NAME])) {
                    $message->to($data[MailHelper::EMAIL_TO]);
                } else {
                    $message->to($data[MailHelper::EMAIL_TO], $data[MailHelper::EMAIL_TO_NAME]);
                }
            });
            
            return count(Mail::failures()) > 0;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function sendTemplateNomalNotTryCatch($template_path, $data, $locale = null)
    {
        if (!isset($data[self::EMAIL_FROM])) {
            $data[self::EMAIL_FROM] = appEmail();
        }
        if (!isset($data[self::EMAIL_FROM_NAME])) {
            $data[self::EMAIL_FROM_NAME] = appName();
        }
        if (!isset($data[self::EMAIL_SUBJECT])) {
            $data[self::EMAIL_SUBJECT] = trans('label.a_message_from') . appName();
        }
        if (!isset($data[self::EMAIL_TO])) {
            return false;
        }
        if (!empty($locale)) {
            $data['site_locale'] = $locale;
        }
        $locale = $data['site_locale'];
        
        Mail::send('emails.' . $template_path . '.' . $locale, $data, function ($message) use ($data) {
            $message->from($data[MailHelper::EMAIL_FROM], $data[MailHelper::EMAIL_FROM_NAME]);
            $message->subject($data[MailHelper::EMAIL_SUBJECT]);
            if (isset($data[MailHelper::EMAIL_TO_NAME])) {
                $message->to($data[MailHelper::EMAIL_TO]);
            } else {
                $message->to($data[MailHelper::EMAIL_TO], $data[MailHelper::EMAIL_TO_NAME]);
            }
        });
    }
}
