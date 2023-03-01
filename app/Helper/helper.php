<?php

use App\Http\Repository\Language\LanguageRepository;
use App\Models\Settings\CmnLanguage;
use App\Models\Settings\CmnTranslation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

function dsAsset($path, $source = null)
{
    return asset($path . '?v=1.0.1', $source);
}

function translate($key, $langId = null)
{

    $langTranslate = Cache::get('langTranslate');
   
    if ($langId == null) {
        if (isset(Session::get('lang')['id'])) {
            $langId = Session::get('lang')['id'];
        }
        else{
            $engLangId = CmnLanguage::where('code', 'en')->select('id')->first()->id;
            $langId = $engLangId;
        }
    }
    if ($langTranslate != array()) {

        if (!isset($langTranslate[$key . '_' . $langId])) {
            //if translate key & value not found in cache
            $trans = CmnTranslation::where('cmn_language_id', $langId)->where('lang_key', $key)->select('lang_value')->first();
            $engLangId = CmnLanguage::where('code', 'en')->select('id')->first()->id;
            if ($trans == null && $langId == $engLangId) {
                //insert default lang value if not found default lang
                CmnTranslation::create([
                    'cmn_language_id' => $langId,
                    'lang_key' => $key,
                    'lang_value' => $key
                ]);
                $langRepo = new LanguageRepository();
                $langRepo->setLangaugeSession($langId);
                return $key;
            } else if ($trans != null) {
                // found key value
                return $trans['lang_value'];
            } else {
                //translation is not found
                return $key;
            }
        } else {
            //return translated value
            return $langTranslate[$key . '_' . $langId];
        }
    } else {
        $trans = CmnTranslation::where('cmn_language_id', $langId)->where('lang_key', $key)->select('lang_value')->first();
        $engLangId = CmnLanguage::where('code', 'en')->select('id')->first()->id;
        if ($trans == null && $langId == $engLangId) {
            //insert default lang value if not found default lang
            CmnTranslation::create([
                'cmn_language_id' => $langId,
                'lang_key' => $key,
                'lang_value' => $key
            ]);
            $langRepo = new LanguageRepository();
            $langRepo->setLangaugeSession($langId);
            return $key;
        } else if ($trans != null) {
            // is not default lang and found key value
            return $trans['lang_value'];
        } else {
            //translation is not found
            return $key;
        }
    }
}
