<?php

include_once BASE_DIR . 'classes/instant_articles/vendor/autoload.php';

use Facebook\InstantArticles\Client\Client;
use Facebook\InstantArticles\Client\Helper;
use Facebook\Facebook;
use Facebook\InstantArticles\Transformer\Transformer;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Elements\Time;
use Facebook\InstantArticles\Elements\Author;
use Facebook\InstantArticles\Elements\Image;
use Facebook\InstantArticles\Elements\Ad;
use Facebook\InstantArticles\Elements\Footer;

class API {

    public static function remove_article($post) {
        Load::model('facebook_settings');

        $fs = FacebookSettings::fetch();

        if (!$fs->is_valid() || HOST_ID != 0) {
            return null;
        }
        /* @var $post BlogPost */

        $ia_client = Client::create($fs->app_id, $fs->secret_id, $fs->page_access_token, $fs->page_id, false);

        try {
            $ia_client->removeArticle(URL::abs($post->permalink . '/' . $post->id));
            $response['msg'] = 'success';
        } catch (Exception $e) {
            $response['error'] = 'Could not import the article: ' . $e->getMessage();
        }

        return $response;
    }

    public static function transform_article($post) {

        Load::model('facebook_settings');
        $fs = FacebookSettings::fetch();

        if (!$fs->is_valid()) {
            return null;
        }

        /* @var $post BlogPost */

        $transformer = new Transformer();
        $rules = file_get_contents(BASE_DIR . 'public/instant-articles-rules.json', true);

        $transformer->loadRules($rules);

        $instant_article = InstantArticle::create();
        $instant_article->enableAutomaticAdPlacement();

        $instant_article->withStyle('Standard');
        $instant_article->withAdDensity('default');

        $instant_article->withCanonicalURL(URL::abs($post->permalink . '/' . $post->id));
        $instant_article->withCharset('utf-8');

        $header = $instant_article->getHeader();
        $header->withTitle($post->title);
        $header->withPublishTime(
                Time::create(Time::PUBLISHED)
                        ->withDatetime(
                                new DateTime($post->release_date)
                        )
        );
        $header->withModifyTime(
                Time::create(Time::MODIFIED)
                        ->withDatetime(
                                new DateTime($post->updated_at)
                        )
        );
        $header->withAuthors([Author::create()->withName(TITLE . ' - Team')]);
        $featured = Image::create()->withURL(URL::abs($post->thumbnail_image_url));
        $header->withCover($featured);
        $header->withKicker('Health Comes First');

        $ad = Ad::create()->withSource('https://www.facebook.com/adnw_request?placement=' . $fs->placement_id . '&adtype=banner300x250');
        $ad->withWidth(300);
        $ad->withHeight(250);
        $header->withAds([$ad]);

        $footer = Footer::create();
        $footer->withCopyright('Ⓒ ' . TITLE);
        $instant_article->withFooter($footer);

        $document = new DOMDocument();
        $document->validateOnParse = false;
        Load::helper('instant_article_helper');
        $post_data = str_replace("\r", "", $post->post);
        $post_data = str_replace("\n", "", $post_data);
        $content = InstantArticleHelper::place_google_ads($post_data);
        $content = trim($content);
        if ($content) {
            @$document->loadHTML($content);
        }
        
        // wrap all of the iframes

        $figure = $document->createElement('figure');
        $figure->setAttribute('class', 'op-interactive');
        $iframes = $document->getElementsByTagName('iframe');
        foreach ($iframes AS $iframe) {
            $new_div_clone = $figure->cloneNode();
            $iframe->parentNode->replaceChild($new_div_clone, $iframe);
            $new_div_clone->appendChild($iframe);
        }

        
        ob_start();
        $transformer->transform($instant_article, $document);
        ob_clean();

        $response = array();
        $response['article'] = $instant_article;
        $response['html'] = $instant_article->render();
        $response['warnings'] = $transformer->getWarnings();

        return $response;
    }

    public static function import_article($instant_article, $public = true) {

        Load::model('facebook_settings');
        $fs = FacebookSettings::fetch();

        $ia_client = Client::create(
                        $fs->app_id, $fs->secret_id, $fs->page_access_token, $fs->page_id, false
        );

        $response = array();

        try {

            $sid = $ia_client->importArticle($instant_article, $public, false, true);

            $status = $ia_client->getSubmissionStatus($sid);
            $response['status'] = $status;
            $response['sid'] = $sid;
            $response['html'] = $instant_article->render();
        } catch (Exception $e) {
            $response['error'] = 'Could not import the article: ' . $e->getMessage();
        }

        return $response;
    }

}
