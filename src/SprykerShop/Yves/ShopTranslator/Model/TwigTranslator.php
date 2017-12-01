<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerShop\Yves\ShopTranslator\Model;

use InvalidArgumentException;
use Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface;
use Symfony\Component\Translation\TranslatorInterface;

class TwigTranslator implements TranslatorInterface
{
    /**
     * @var \Spryker\Client\GlossaryStorage\GlossaryStorageClientInterface
     */
    private $client;

    /**
     * @var string
     */
    private $localeName;

    /**
     * @param GlossaryStorageClientInterface $client
     * @param null $localeName
     */
    public function __construct(GlossaryStorageClientInterface $client, $localeName = null)
    {
        $this->client = $client;
        $this->localeName = $localeName;
    }

    /**
     * Translates the given message.
     *
     * @api
     *
     * @param string $identifier The message id (may also be an object that can be cast to string)
     * @param array $parameters An array of parameters for the message
     * @param string|null $domain The domain for the message or null to use the default
     * @param string|null $locale The locale or null to use the default
     *
     * @return string The translated string
     */
    public function trans($identifier, array $parameters = [], $domain = null, $locale = null)
    {
        if ($locale === null) {
            $locale = $this->localeName;
        }

        return $this->client->translate($identifier, $locale, $parameters);
    }

    /**
     * Translates the given choice message by choosing a translation according to a number.
     *
     * @api
     *
     * @param string $identifier The message id (may also be an object that can be cast to string)
     * @param int $number The number to use to find the indice of the message
     * @param array $parameters An array of parameters for the message
     * @param string|null $domain The domain for the message or null to use the default
     * @param string|null $locale The locale or null to use the default
     *
     * @throws \InvalidArgumentException If the locale contains invalid characters
     *
     * @return string The translated string
     */
    public function transChoice($identifier, $number, array $parameters = [], $domain = null, $locale = null)
    {
        if ($locale === null) {
            $locale = $this->localeName;
        }

        $ids = explode('|', $identifier);

        if ($number === 1) {
            return $this->client->translate($ids[0], $locale, $parameters);
        }

        if (!isset($ids[1])) {
            throw new InvalidArgumentException(sprintf('The message "%s" cannot be pluralized, because it is missing a plural (e.g. "There is one apple|There are %%count%% apples").', $identifier));
        }

        return $this->client->translate($ids[1], $locale, $parameters);
    }

    /**
     * @param string $localeName
     *
     * @return $this
     */
    public function setLocale($localeName)
    {
        $this->localeName = $localeName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->localeName;
    }
}
