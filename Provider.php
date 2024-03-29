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
     *
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            'sub' => $user['sub'],
            'ident' => $user['ident'],
            'name' => $user['name'],
            'email' => $user['email'],
            'address' => $user['address'],
            'date_of_birth' => $user['date_of_birth'],
            'department_and_level' => $user['department_and_level'],
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