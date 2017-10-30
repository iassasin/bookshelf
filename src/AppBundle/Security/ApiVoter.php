<?php

namespace AppBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ApiVoter extends Voter
{
    const VALID_API_KEY = 'valid_api_key';

    /** @var string */
    private $apiKey;
    /** @var RequestStack */
    private $requestStack;

    public function __construct($apiKey, RequestStack $requestStack)
    {
        $this->apiKey = $apiKey;
        $this->requestStack = $requestStack;
    }

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, [self::VALID_API_KEY])) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $request = $this->requestStack->getCurrentRequest();

        switch ($attribute) {
            case self::VALID_API_KEY:
                $apiKey = $request->query->get('api_key');
                return $apiKey == $this->apiKey;
        }

        throw new \LogicException('This code should not be reached!');
    }
}
