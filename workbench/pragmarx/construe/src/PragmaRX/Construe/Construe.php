<?php namespace PragmaRX\Construe;
/**
 * Part of the Construe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Construe
 * @version    1.0.0
 * @author     Antonio Carlos Ribeiro @ PragmaRX
 * @license    BSD License (3-clause)
 * @copyright  (c) 2013, PragmaRX
 * @link       http://pragmarx.com
 */

use PragmaRX\Construe\Support\Locale;
use PragmaRX\Construe\Support\SentenceBag;
use PragmaRX\Construe\Support\Sentence;
use PragmaRX\Construe\Support\Config;
use PragmaRX\Construe\Messages\MessageInterface;

class Construe
{
	private $module = 0;

	private $locale;

	/**
	 * Initialize Construe object
	 * 
	 * @param Locale $locale
	 */
	public function __construct(Config $config, Locale $locale, SentenceBag $paragraph, MessageInterface $messageRepository) 
	{
		$this->locale = $locale;

		$this->config = $config;

		$this->paragraph = $paragraph;

		$this->messageRepository = $messageRepository;
	}

	/**
	 * Module setter
	 * 
	 * @param integer $module
	 */
	public function setModule($module)
	{
		$this->module = $module;
	}

	/**
	 * Module getter
	 * 
	 * @return integer
	 */
	public function getModule()
	{
		return $this->module;
	}

	/**
	 * Locale setter
	 * 
	 * @param Locale $locale
	 */
	public function setLocale(Locale $locale)
	{
		$this->locale = $locale;
	}

	/**
	 * Locale getter
	 * 
	 * @return Locale
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * Translate a group of paragraph
	 * 
	 * @param  string  $paragraph
	 * @param  Locale  $locale
	 * @param  integer $module
	 * @param  array  $variables
	 * @return string
	 */
	public function translate($paragraph, array $variables = null, $locale = null, $module = 0)
	{
		return $this->replaceVariables(
										$this->translateParagraph($paragraph, $locale ?: $this->locale, $module ?: $this->module), 
										$variables
									);
	}

	/**
	 * Iterate tru the paragraph and translate one by one
	 * 
	 * @param  string $paragraph
	 * @param  Locale $locale
	 * @param  integer $module
	 * @return string
	 */
	private function translateParagraph($paragraph, Locale $locale, $module)
	{
		$this->paragraph->parseParagraph($paragraph);

		foreach($this->paragraph->all() as $sentence)
		{
			$sentence->translated = $this->translateSentence($sentence, $locale, $module);
		}

		return $this->paragraph->getTranslatedParagraph();
	}

	/**
	 * Receives a sentence and translate it
	 * 
	 * @param  Sentence $sentence
	 * @param  Locale $locale
	 * @param  int $module
	 * @return string
	 */
	private function translateSentence($sentence, $locale, $module)
	{
		return $this->messageRepository->findMessage($sentence, $locale, $module)->translated;
	}

	/**
	 * Replace all user variables by its respective values
	 * 
	 * @param  string $translated
	 * @param  array $variables
	 * @return strinf
	 */
	private function replaceVariables($string, array $variables)
	{
		if(is_array($variables))
		{
			foreach($variables as $key => $variable) {
				$string = $this->replaceVariable($key, $variable, $string);
			}
		}

		return $string;
	}

	/**
	 * Replace one user variables by its respective value
	 * 
	 * @param  string $key
	 * @param  string $variable
	 * @param  string $translated
	 * @return string
	 */
	private function replaceVariable($key, $variable, $translated)
	{
		return str_replace(
							$this->config->get('variable_delimiter_prefix') . "$key" . $this->config->get('variable_delimiter_suffix'), 
							$variable, 
							$translated
						);
	}

}

	// private function translateSentence($sentence, $locale, $module)
	// {
	// 	$sentence->messageID = $this->buildMessageID($sentence, $locale, $module);

	// 	$originalMessage = $this->getMessage($sentenceID);

	// 	if (!isset($originalMessage) or empty($originalMessage)) {
	// 		$this->newMessage($sentenceID, $this->getDefaultLanguage(), $this->getDefaultCountry(), $module, $hash, $sentence);
	// 	}

	// 	if (!$this->isDefaultLanguage($languageID, $countryID)) {
	// 		$sentenceID = $this->buildMessageID($hash, $this->language, $this->country, $module);
	// 		$translatedMessage = $this->getMessage($sentenceID);
	// 		if ( isset($translatedMessage) and !empty($translatedMessage) ) {
	// 			return $translatedMessage;
	// 		}
	// 		\Log::warning("not found = $sentence - $hash - $sentenceID");
	// 		$this->newMessage($sentenceID, $this->language, $this->country, $module, $hash, $sentence);
	// 	}

	// 	return $sentence;
	// }

	// 	$this->loadLanguages();
	// 	$this->loadMessages();

	// private function loadLanguages() {
	// 	// $query = \DB::select("select cl.language_id, cl.country_id , l.name language_name , c.name country_name , concat(l.name,' (', c.name, ')') as regional_name, cl.enabled  from countries_languages cl  join languages l on l.id = cl.language_id  join countries c on c.id = cl.country_id;");
		
	// 	// foreach ($query as $record) {
	// 	// 		$this->languages[$record->language_id."-".$record->country_id] = array(
	// 	// 																				  'language_id' => $record->language_id
	// 	// 																				, 'country_id' => $record->country_id
	// 	// 																				, 'language_name' => $record->language_name
	// 	// 																				, 'country_name' => $record->country_name
	// 	// 																				, 'regional_name' => $record->regional_name
	// 	// 																				, 'enabled' => $record->enabled
	// 	// 																		);
	// 	// }
	// }

	// private function loadMessages() {
	// 	$this->messages = array();    
		
	// 	// $query = \DB::table('messages')->where('language_id', '=', $this->getDefaultLanguage())->where('country_id','=', $this->getDefaultCountry())->get();
	// 	// foreach ($query as $record) {
	// 	// 	$messageID = $this->buildMessageID($record->message_hash, $record->language_id, $record->country_id, $record->module_id);
	// 	// 	$this->messages[$messageID] = $record->message;
	// 	// }

	// 	// $query = \DB::table('messages')->where('language_id', '=', $this->language)->where('country_id','=', $this->country)->get();
	// 	// foreach ($query as $record) {
	// 	// 	$messageID = $this->buildMessageID($record->message_hash, $record->language_id, $record->country_id, $record->module_id);
	// 	// 	$this->messages[$messageID] = $record->message;
	// 	// }
	// }
	// static function translate($messages, $module = 0, $replacements)
	// {
	// 	if (\Auth::check()) {
	// 		$language = \Auth::user()->language_id;
	// 		$country = \Auth::user()->country_id;
	// 	} else {
	// 		$language = \Session::get('languageID');
	// 		$country = \Session::get('countryID');
	// 	}

	// 	$translator = \App::make('erobin.translator');

	// 	return ($translator->debug() ? '{' : '').$translated.($translator->debug() ? '}' : '');
	// }

	// private function newMessage($messageID, $languageID, $countryID, $module, $hash, $message) {
	// 	try 
	// 	{
	// 		$model = new \Message;
	// 		$model->language_id = $languageID;
	// 		$model->country_id = $countryID;
	// 		$model->module_id = $module;
	// 		$model->message_hash = $hash; // this hash is the untranslated form of the message
	// 		$model->message = $message; // this is the message already translated
	// 		$model->save();
	// 		$result = $message;
	// 	} 
	// 	catch (\Exception $e) {
	// 		dd($e);
	// 	}
	// 	$this->setMessage($messageID,$message);
	// }
	
	// private function isDefaultLanguage($lID, $cID) {
	// 	return ($lID == $this->getDefaultLanguage()) and ($cID = $this->getDefaultCountry());
	// }

	// private function removePrefixAndSuffix(&$message, &$prefix, &$suffix) {
	// 	$prefix = '';
	// 	$suffix = '';
		
	// 	$chars = array( "!"=>1,"\\"=>1,"\""=>1,"#"=>1,"\$"=>1,"%"=>1,"&"=>1,"'"=>1,"("=>1,")"=>1,"*"=>1,"+"=>1,","=>1,"-"=>1,"."=>1,"/"=>1,":"=>1,";"=>1,"<"=>1,"="=>1,">"=>1,"?"=>1,"@"=>1,"["=>1,"]"=>1,"^"=>1,"_"=>1,"`"=>1,"{"=>1,"|"=>1," "=>1,"}"=>1 );

	// 	$i = 0;
	// 	while ($i < strlen($message) and isset($chars[$message[$i]])) {
	// 		$prefix .= $message[$i];
	// 		$i++;
	// 	}
	// 	$i = strlen($message)-1;
	// 	while ($i > -1 and isset($chars[$message[$i]])) {
	// 		$suffix = $message[$i] . $suffix;
	// 		$i--;
	// 	}

	// 	if ($prefix != $this->variableDelimiterPrefix) {
	// 		$message = substr($message,strlen($prefix));	
	// 	} else {
	// 		$prefix = '';
	// 	}
		
	// 	if ($suffix != $this->variableDelimiterSuffix) {
	// 		$message = substr($message,0,strlen($message)-strlen($suffix));
	// 	} else {
	// 		$suffix = '';
	// 	}
	// }

	// private function getMessage($messageID) {
	// 	if (!isset($this->messages[$messageID])) {
	// 		\Log::warning("not found! |$messageID|");
	// 		if (!$this->did) {
	// 			foreach($this->messages as $key => $data) {
	// 				\Log::warning("$key => $data");
	// 			}
	// 			$this->did = true;  
	// 		}
	// 		foreach($this->messages as $key => $message) {
	// 			if ($key == $messageID) {
	// 				\Log::warning("FOUND! |$key| == |$messageID|");
	// 			}
	// 		}
	// 	}

	// 	return isset($this->messages[$messageID]) ? $this->messages[$messageID] : NULL;
	// }
	
	// private function setMessage($messageID,$message) {
	// 	return $this->messages[$messageID] = $message;
	// }

	// private function getLanguages() {
	// 	if(!isset($this->languages))  {
	// 		$this->loadLanguages();
	// 	}
	// 	return $this->languages;
	// }

	// static function languages()
	// {
	// 	$translator = \App::make('erobin.translator');
	// 	return $translator->getLanguages();
	// }

	// static function languageName($language_id, $country_id) {
	// 	$translator = \App::make('erobin.translator');
	// 	return $translator->languages[$language_id."-".$country_id]['regional_name'];
	// }

	// public function debug() {
	// 	return \Config::get('app.debugTranslation');
	// }

	// private function getDefaultLanguage() {
	// 	$l = \Config::get('app.defaultLanguage');
	// 	if (!isset($l) or empty($l)) {
	// 		$l = self::DEFAULT_LANGUAGE_ID;
	// 	}
	// 	return $l;
	// }

	// private function getDefaultCountry() {
	// 	$c = \Config::get('app.defaultCountry');
	// 	if (!isset($c) or empty($c)) {
	// 		$c = self::DEFAULT_COUNTRY_ID;
	// 	}
	// 	return $c;
	// }

	// private function setCurrentLanguage($languageID, $countryID) {
	// 	if (!isset($languageID)) {
	// 		if (!isset($this->language)) {
	// 			$languageID = $this->getDefaultLanguage();
	// 		} else {
	// 			$languageID = $this->language;
	// 		}
	// 	}

	// 	if (!isset($countryID)) {
	// 		if (!isset($this->country)) {
	// 			$countryID = $this->getDefaultCountry();
	// 		} else {
	// 			$countryID = $this->country;
	// 		}
	// 	}

	// 	if ($this->language != $languageID or $this->country != $countryID) {
	// 		$this->language = $languageID;
	// 		$this->country = $countryID;

	// 		$this->loadMessages();
	// 	}
	// }

	// static function variableDelimiterPrefix() {
	// 	return \App::make('erobin.translator')->variableDelimiterPrefix;
	// }

	// static function variableDelimiterSuffix() {
	// 	return \App::make('erobin.translator')->variableDelimiterSuffix;
	// }