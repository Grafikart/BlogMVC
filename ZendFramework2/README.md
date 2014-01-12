Checkout project and run composer install

# BlogMVC | ZendFramework 2

## Install
- Change db settings in ```config/autoload/doctrine.local.php```
- Run composer : ```composer install```
- Create database using ```dump.sql```

## Informations
### General
- Service manager = Service locator it's just two names form the same component
### Factory
- A factory is a class specialized in creation of other class.
- For most of the case in controller we can use trait or retrieve form, service or other from the service manager but
for this tutorial I have decided to use Factory with hard dependency. This is more readable and easy to write unit test
because mock a service, form or other is more easiest thant mock the service manager.
- In a Factory the service locator injected is not always the global service locator but a specialized service locator.
For example when we create a controller from with Factory, the service locator injected is Zend\Mvc\Controller\ControllerManager
to retrieve the global service locator : ```$serviceLocatorSpecialized->getServiceLocator()```
### Form
- In controller when binding an entity to a form it's passed by reference so whe don't need doing this :
```$entity = $form->getData()``` but for a better readable code we doing it