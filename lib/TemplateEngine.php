<?php
declare(strict_types=1);

namespace lib;

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\FormRenderer;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Csrf\TokenGenerator\UriSafeTokenGenerator;
use Symfony\Component\Security\Csrf\TokenStorage\NativeSessionTokenStorage;
use Twig\Environment as TwigEnviorment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extensions\I18nExtension;
use Twig\Loader\FilesystemLoader as FilesystemLoader;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

class TemplateEngine implements TemplateInterface
{
    private  TwigEnviorment $twig;

    private FilesystemLoader $loader;

    // Not ideal setup, will look at better implementations, this was quick and dirty to get it going
    public function __construct()
    {
        $defaultFormTheme = 'bootstrap_4_layout.html.twig';
        $appVariableReflection = new \ReflectionClass('\Symfony\Bridge\Twig\AppVariable');
        $vendorTwigBridgeDirectory = dirname($appVariableReflection->getFileName());

        $this->loader = new FilesystemLoader(['templates', $vendorTwigBridgeDirectory.'/Resources/views/Form']);
        $this->twig = new TwigEnviorment($this->loader, ['debug' => true]);

        $this->twig->addExtension(new I18nExtension());
        $this->twig->addExtension(new FormExtension());

        $formEngine = new TwigRendererEngine([$defaultFormTheme],  $this->twig);
        $this->twig->addRuntimeLoader(new FactoryRuntimeLoader([
            FormRenderer::class => function () use ($formEngine) {
                return new FormRenderer($formEngine);
            },
        ]));
    }

    public function render(string $templatePath, array $templateVariables = []): string
    {
        try {
            return $this->twig->render($templatePath, $templateVariables);
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            // throw custom exception
            print_r($e->getMessage());
            // add logger
            die('error wtf neil');
        }
    }
}
