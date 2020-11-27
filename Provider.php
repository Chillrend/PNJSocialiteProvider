<?php

namespace SocialiteProviders\PNJ;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'PNJ';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [
        'openid',
    ];

    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://auth.pnj.ac.id/oauth2/auth', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://auth.pnj.ac.id/oauth2/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->post('https://auth.pnj.ac.id/userinfo', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Accept' => 'application/json'
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * TODO: Change the fields after database migration
     *
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'id'         => $user['sub'],
            'email'      => $user['email'],
            'name'       => $user['name'],
            'sid'        => $user['sid'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
        ]);
    }
}