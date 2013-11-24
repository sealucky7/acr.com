<?php namespace PragmaRX\Glottos\Repositories\Data;
/**
 * Part of the Glottos package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Glottos
 * @version    1.0.0
 * @author     Antonio Carlos Ribeiro @ PragmaRX
 * @license    BSD License (3-clause)
 * @copyright  (c) 2013, PragmaRX
 * @link       http://pragmarx.com
 */

use PragmaRX\Glottos\Support\Sentence;
use PragmaRX\Glottos\Support\Locale;
use PragmaRX\Glottos\Support\Config;
use PragmaRX\Glottos\Repositories\Messages\MessageInterface;
use PragmaRX\Glottos\Repositories\Locales\LocaleRepositoryInterface;

class DataRepository implements DataRepositoryInterface {

	private $message;

	private $translation;

	private $localeRepository;

	public function __construct(MessageInterface $message, MessageInterface $translation, LocaleRepositoryInterface $localeRepository, Config $config)
	{
		$this->message = $message;

		$this->translation = $translation;

		$this->localeRepository = $localeRepository;

		$this->config = $config;
	}

	public function findSentence(Sentence $sentence)
	{
		if (! $sentence->getId())
		{
			$sentence = $this->message->find($sentence);
		}

		return $sentence;
	}

	public function findTranslation(Sentence $sentence, Locale $locale)
	{
		$sentence = $this->findSentence($sentence);

		$translation = $this->translation->find($sentence, $locale);

		if(! $translation->translationFound && $sentence->getMode() == 'natural' && $locale->is($this->getDefaultLocale()))
		{
			$translation = $this->addTranslation($sentence, $this->getDefaultLocale());
		}

		return $translation;
	}

	public function getDefaultLocale()
	{
		return Locale::make($this->config->get('default_language_id').'-'.$this->config->get('default_country_id'));
	}

	public function addTranslation(Sentence $translation, Locale $locale)
	{
		$this->translation->add($translation, $locale);

		return $translation;
	}

	public function localeIsAvailable($locale)
	{
		if ($this->getDefaultLocale()->is($locale))
		{
			return true;
		}

		return $this->localeRepository->localeIsAvailable(Locale::make($locale));
	}

	public function getAllLanguages()
	{
		return $this->localeRepository->getAllLanguages();
	}

	public function enableDisableLanguage($id, $enable)
	{
		return $this->localeRepository->enableDisableLanguage($id, $enable);
	}
}