<?php

namespace SocialiteProviders\PNJ;

use SocialiteProviders\Manager\SocialiteWasCalled;

class PNJExtendSocialite
{
    /**
     * Register the provider.
     *
     * @param \SocialiteProviders\Manager\SocialiteWasCalled $socialiteWasCalled
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('pnj', Provider::class);
    }
}
