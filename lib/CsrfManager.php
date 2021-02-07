<?php
declare(strict_types=1);

namespace lib;

use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\NativeSessionTokenStorage;

//PLEASE NOTE THIS IS A BASIC MVP, EXCEPTIONS ETC TO COME!
class CsrfManager implements CsrfManagerInterface
{
    /**
     * @var UriSafeTokenGenerator
     */
    private UriSafeTokenGenerator $csrfGenerator;

    /**
     * @var NativeSessionTokenStorage
     */
    private NativeSessionTokenStorage $csrfStorage;

    /**
     * @var CsrfTokenManager
     */
    private CsrfTokenManager $csrfManager;

    public function __construct()
    {
        $this->csrfGenerator = new UriSafeTokenGenerator();
        $this->csrfStorage = new NativeSessionTokenStorage();
        $this->csrfManager = new CsrfTokenManager($this->csrfGenerator, $this->csrfStorage);
    }

    public function getToken(string $tokenId): CsrfToken
    {
        return $this->csrfManager->getToken($tokenId);
    }

    public function isValidToken(string $tokenId, string $submittedToken): bool
    {
        $token = $this->getToken($tokenId);

        if($submittedToken === "") {
            return false;
        }

        if ($token->getValue() !== $submittedToken) {
            return false;
        }

        return $this->csrfManager->isTokenValid($token);
    }

}
