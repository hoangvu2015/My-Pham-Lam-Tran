<?php
/**
 * Created by PhpStorm.
 * User: Nguyen Tuan Linh
 * Date: 2015-09-16
 * Time: 01:46
 */

namespace Antoree\Models\Helpers;

class AppHelper
{
    const SESSION_RDR = 'x_rdr';
    const SESSION_SRS = 'x_selected_roles';
    const SESSION_WZK = 'x_wizard_key';
    const QPR_FORCE_LANG = 'x_force_lang';
    const QPR_FORCE_TEMPLATE = 'x_force_template';

    const REGEX_YOUTUBE_URL = '/^(http:\/\/|https:\/\/|\/\/)(www.|m.|)(youtube.com\/watch\?v=|youtube.com\/embed\/|youtu.be\/)(.+)$/';

    const DEFAULT_ITEMS_PER_PAGE = 10;
    const TMP_LRS_PER_PAGE = 20;
    const PUB_POP_REVIEWS_PER_PAGE = 3;
    const PUB_TEACHERS_PER_PAGE = 6;
    const PUB_COURSES_PER_PAGE = 9;

    const TITLE_SHORTEN_TEXT_LENGTH = 25;
    const TINY_SHORTEN_TEXT_LENGTH = 75;
    const SMALL_SHORTEN_TEXT_LENGTH = 150;
    const DEFAULT_SHORTEN_TEXT_LENGTH = 200;
    const MEDIUM_SHORTEN_TEXT_LENGTH = 300;
    const LONG_SHORTEN_TEXT_LENGTH = 400;
    const SITE_DESCRIPTION_SHORTEN_TEXT_LENGTH = 300;
    const REVIEW_SHORTEN_TEXT_LENGTH = 125;
    const SHORT_TEACHER_ABOUT_LENGTH = 175;
    const MEDIUM_TEACHER_ABOUT_LENGTH = 250;
    const BLOG_ARTICLE_SHORTEN_LENGTH = 400;

    const WIZARD_INTERNAL_LR = 'internal-learning-request';
    const WIZARD_EXTERNAL_LR = 'external-learning-request';

    const INTERNATIONAL_COUNTRY_CODE = '--';
    const INTERNATIONAL_LOCALE_CODE = '--';

    const DEFAULT_PAGINATION_ITEMS = 5;
    const ON_PHONE_PAGINATION_ITEMS = 4;
}