<?php namespace PragmaRX\Glottos\Repositories;
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

use Symfony\Component\Finder\Finder;

use PragmaRX\Glottos\Support\Sentence;
use PragmaRX\Glottos\Support\Locale;
use PragmaRX\Glottos\Support\Config;
use PragmaRX\Glottos\Support\Filesystem;

use PragmaRX\Glottos\Repositories\Messages\MessageInterface;
use PragmaRX\Glottos\Repositories\Locales\LocaleRepositoryInterface;

class DataRepository implements DataRepositoryInterface {

	private $message;

	private $translation;

	private $localeRepository;

	public function __construct(
									MessageInterface $message, 
									MessageInterface $translation, 
									LocaleRepositoryInterface $localeRepository, 
									Config $config,
									Filesystem $fileSystem
								)
	{
		$this->message = $message;

		$this->translation = $translation;

		$this->localeRepository = $localeRepository;

		$this->config = $config;

		$this->fileSystem = $fileSystem;
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

	public function findTranslationById($message_id, Locale $locale)
	{
		return $this->translation->findById($message_id, $locale);
	}

	public function findMessageById($message_id)
	{
		return $this->message->findById($message_id);
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
		return $this->localeRepository->getLanguages();
	}

	public function getEnabledLanguages()
	{
		return $this->localeRepository->getLanguages('enabled', '=', 'true');
	}

	public function getDisabledLanguages()
	{
		return $this->localeRepository->getLanguages('enabled', '=', 'false');
	}

	public function enableDisableLanguage($id, $enable)
	{
		return $this->localeRepository->enableDisableLanguage($id, $enable);
	}

	public function getLanguageStats()
	{
		return $this->localeRepository->getLanguageStats();
	}

	public function getTranslations(Locale $localePrimary = null, Locale $localeSecondary = null)
	{
		return $this->translation->getAll($localePrimary, $localeSecondary);
	}

	public function findLocale(Locale $locale)
	{
		 return $this->localeRepository->find($locale);
	}

	public function updateOrCreateTranslation($message, $translatedMessage, Locale $locale, $module = 0, $mode)
	{
		$this->translation->updateOrCreate($message, $translatedMessage, $locale, $module, $mode);
	}

	public function findNextUntranslated(Locale $primaryLocale, Locale $secondaryLocale)
	{
		return $this->translation->findNextUntranslated($primaryLocale, $secondaryLocale);
	}	

	public function import($app, $path, $module, $mode)
	{
		if( ! $path)
		{
			$path = $app['path.base'].'/app/lang';
		}

		$locales = $this->fileSystem->directories($path);

		$imported = 0;

		foreach($locales as $locale)
		{
			$imported += $this->importLocale(basename($locale), dirname($locale), $module, $mode);
		}

		return $imported;
	}

	private function importLocale($locale, $path, $module, $mode)
	{
		$imported = 0;

		$locale = Locale::make($locale);

		foreach(Finder::create()->files()->in($path.'/'.$locale->getText()) as $file)
		{
			$values = $this->fileSystem->getRequire($file);

			$group = str_replace('.php', '', basename($file));

			if ($group !== 'validation')
			{
				foreach($values as $key => $value)
				{
					if($this->addKey($group, $key, $value, $locale, $module, $mode))
					{
						$imported++;
					}
				}
			}
		}

		return $imported;
	}

	public function addKey($group, $key, $value, $locale, $module, $mode)
	{
		$translation = Sentence::makeTranslation(
												"key::$group.$key",
												$value,
												$module,
												$mode
											);

		$translation = $this->findTranslation($translation, $locale);

		if(! $translation->translationFound)
		{
			$this->addTranslation($translation, $locale);

			return true;
		}

		return false;
	}
}