<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerShop\Yves\ShopTranslator\Plugin\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method \SprykerShop\Yves\ShopTranslator\ShopTranslatorFactory getFactory()
 * @method \Spryker\Client\Glossary\GlossaryClientInterface getClient()
 */
class TranslationServiceProvider extends AbstractPlugin implements ServiceProviderInterface
{
    protected const SERVICE_TRANSLATOR = 'translator';

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function register(Application $app)
    {
        $app[static::SERVICE_TRANSLATOR] = $app->share(function ($app) {
            $twigTranslator = $this->getFactory()->createTwigTranslator(
                $app['locale']
            );

            return $twigTranslator;
        });

        $app->configure(static::SERVICE_TRANSLATOR, ['isGlobal' => true]);
    }

    /**
     * @param \Silex\Application $app
     *
     * @return void
     */
    public function boot(Application $app)
    {
    }
}
