<?php
declare(strict_types=1);

namespace lib;

use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\NativeSessionTokenStorage;

class FormFactoryBuilder implements FormBuilderFactoryInterface
{
    private UriSafeTokenGenerator $csrfGenerator;

    private CsrfTokenManager $csrfManager;

    private NativeSessionTokenStorage $csrfStorage;

    public function __construct()
    {
        $this->csrfGenerator = new UriSafeTokenGenerator();
        $this->csrfStorage = new NativeSessionTokenStorage();
        $this->csrfManager = new CsrfTokenManager($this->csrfGenerator, $this->csrfStorage);
    }

    public function createFormBuilderFactory(): FormFactoryInterface
    {
        return Forms::createFormFactoryBuilder()
            ->addExtension(new CsrfExtension($this->csrfManager))
            ->getFormFactory();
    }

}
