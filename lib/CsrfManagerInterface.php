<?php

namespace lib;

use Symfony\Component\Security\Csrf\CsrfToken;

interface CsrfManagerInterface
{
    /**
     * @param string $tokenId
     * @return CsrfToken
     */
    public function getToken(string $tokenId): CsrfToken;

    /**
     * @param string $tokenId
     * @param string $submittedToken
     * @return bool
     */
    public function isValidToken(string $tokenId, string $submittedToken): bool;

}
