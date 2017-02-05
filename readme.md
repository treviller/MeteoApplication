MeteoBundle
===========

Ce bundle utilise l'API OpenWeatherMap pour fournir des renseignements m�t�orologiques sur une liste de villes pr�-�tablies, ainsi que sur n'importe quelle ville recherch�e ou g�olocalis�e.

Mise en place
=============

Afin de mettre en place ce bundle, plusieurs �tapes sont n�cessaires :

1) Enregistrement du bundle
---------------------------

Il est bien entendu n�cessaire d'enregistrer sont bundle dans le fichier AppKernel.php :

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

Il faut �galement enregistrer le fichier routing.yml du bundle dans le fichier routing.yml g�n�ral :

```yaml

    meteo:
        resource: "@MeteoBundle/Resources/config/routing.yml"
        prefix: /

```

3) Cl� d'API 
------------

Ce bundle utilisant une API, il est donc n�cessaire d'enregistrer votre propre cl� d'API dans le fichier parameters.yml de votre projet de la fa�on suivante :


```yaml

    parameters:
            api_key: **********************************

```

4) Installation des assets
--------------------------

L'installation des assets du bundle est n�cessaire pour la mise en forme de celui-ci. Il suffit d'utiliser cette commande :

```console
$php bin/console assets:install --symlink
```

5) D�pendance
-------------

Le bundle utilise le client Guzzle pour fonctionner. Il est donc n�cessaire de l'ajouter aux d�pendances composer :

```console
$composer require guzzlehttp/guzzle ^6.2
```

Le bundle est fin pr�t � �tre utilis� !