# Symfony Forms In Custom PHP App POC (OUTDATED - TBD: 17 May 2021)

**(WIP)**

This is a proof of concept. Here i am implementing symfony forms in a custom (non-symfony) native PHP project. I am trying to keep to clean architecture and keep everything as SOLID as possible. In this project i make use of simple routing, Dependency injection and some other familiar things you might see in the codebase. Please note there is not any logging in this application nor is there any connection to the DB, i print and die on a successful submit.

**Please Note: There is still a lot to do in my opinion regarding this project, i still need to abstract away some of the symfony classes we see here - This is far from perfect still**

## Main Packages used
- league/route (For routing)
- league/container (DI Container)
- twig/twig
- symfony/form
- symfony/twig-bridge
- symfony/security-csrf
- symfony/translation
- twig/extensions
- symfony/psr-http-message-bridge
- symfony/validator
- doctrine/annotations

## Installation

```bash
    git clone [repo_url]
    composer install
    php -S 0.0.0.0:3000
```


## Usage

If you are using an DI container please be sure to inject the `FormBuilderFactoryInterface` into the controller you are using, once you have ensured you have the factory injected/included we can go ahead to create the Form as follows:
```php
        $this->formBuilder->create(
            'formDemo',
            '/neils-form-test',
            'token',
            new TextInput(
                'name',
                'Name',
                [
                    new Length(['min' => 5]),
                    new Assert\NotBlank()
                ]
            ),
            new TextInput(
                'description',
                'Description',
                [
                    new Length(['min' => 5]),
                    new Assert\NotBlank()
                ]
            ),
            new TextAreaInput(
                'TextArea',
                'textarea'
            ),
            new CheckboxInput(
                'Checkbox',
                'checkbox',
                ['test1','test2']
            ),
            new RadioButtonInput(
                'RadioButton',
                'radioButton',
                ['test1','test2']
            ),
        );
```
Unfortunately at this stage we are still tied to the FormInterface of Symfony (This will be replaced with our own interface extending the symfony interface that we are not directly tied symfony in every controller we are adding forms in).

## Creating New Field Types

TBD


## Testing

TBD


