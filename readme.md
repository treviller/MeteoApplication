MeteoBundle
===========

Ce bundle utilise l'API OpenWeatherMap pour fournir des renseignements météorologiques sur une liste de villes pré-établies, ainsi que sur n'importe quelle ville recherchée ou géolocalisée.

Mise en place
=============

Afin de mettre en place ce bundle, plusieurs étapes sont nécessaires :

1) Enregistrement du bundle
---------------------------

Il est bien entendu nécessaire d'enregistrer sont bundle dans le fichier AppKernel.php :

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new MeteoBundle\MeteoBundle(),
        );

        // ...
    }

    // ...
}
```


2) Routing
----------

Il faut également enregistrer le fichier routing.yml du bundle dans le fichier routing.yml général :

```yaml

    meteo:
        resource: "@MeteoBundle/Resources/config/routing.yml"
        prefix: /

```

3) Clé d'API 
------------

Ce bundle utilisant une API, il est donc nécessaire d'enregistrer votre propre clé d'API dans le fichier parameters.yml de votre projet de la façon suivante :


```yaml

    parameters:
            api_key: **********************************

```

4) Installation des assets
--------------------------

L'installation des assets du bundle est nécessaire pour la mise en forme de celui-ci. Il suffit d'utiliser cette commande :

```console
$php bin/console assets:install --symlink
```

5) Dépendance
-------------

Le bundle utilise le client Guzzle pour fonctionner. Il est donc nécessaire de l'ajouter aux dépendances composer :

```console
$composer require guzzlehttp/guzzle ^6.2
```

Le bundle est fin prêt à être utilisé !