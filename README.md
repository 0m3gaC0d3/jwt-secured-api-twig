![alt text](https://travis-ci.org/0m3gaC0d3/jwt-secured-api-twig.svg?branch=master "Build status")

# JWT secured API - Twig

This package integrates the template engine [twig](https://twig.symfony.com/) into the api frame work.

## Use twig in actions

This package allows you to create actions with twig rendering out of the box.
You only have your action class extending `\OmegaCode\JwtSecuredApiTwig\Action\AbstractTwigAction`.

An example could be:
```php
namespace Vendor\MyProject\Action;

use OmegaCode\JwtSecuredApiTwig\Action\AbstractTwigAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexAction extends AbstractTwigAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        return $this->render($response, [
            'currentTime' => time(),
        ]);
    }

    protected function getTemplateFilePath(): string
    {
        return 'index.html'; // res/templates/index.html
    }
}
```

## Use twig to render

To use twig to render a template file, you can simply inject the service `Twig\Environment`.
An example on how to use the service can be found in class `\OmegaCode\JwtSecuredApiTwig\Action\AbstractTwigAction`.

## Manipulate template directories

Maybe you want to change the default loading directory for twig templates (`res/templates`).
This can be archived by creating a subscriber like below.

```yaml
services:
  Vendor\MyProject\Subscriber\TwigTemplateSubscriber:
    tags:
      - 'kernel.event_subscriber'
```

```php
namespace Vendor\MyProject\Subscriber;

use OmegaCode\JwtSecuredApiTwig\Event\Twig\CollectTemplatesEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TwigTemplateSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CollectTemplatesEvent::NAME => 'onCollectTemplates',
        ];
    }

    public function onCollectTemplates(CollectTemplatesEvent $event): void
    {
        $event->addTemplatePath(APP_ROOT_PATH . '/my/custom/templates');
    }
}
```
