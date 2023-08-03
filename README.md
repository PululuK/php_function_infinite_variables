# INTRODUCTION

Les fonctions, en tant que concept fondamental de la programmation informatique, jouent un rôle essentiel dans la résolution de problèmes complexes et la création de logiciels robustes et modulaires. Depuis les débuts de l'informatique, les fonctions ont été l'une des pierres angulaires de la programmation, offrant aux développeurs un moyen puissant de diviser un programme en unités de traitement logique, réutilisables et bien définies.

Au fil des décennies, le concept de fonction a évolué, donnant naissance à de multiples paradigmes de programmation, tels que la programmation procédurale, la programmation orientée objet et la programmation fonctionnelle. Chaque approche offre des avantages spécifiques, et les fonctions continuent d'être au cœur de chacune d'entre elles.


Dans ce project, nous allons implementer la notion d'une fonction à multiple variable en php.

## Problematique


### Défis liés aux Fonctions ou Méthodes avec un Grand Nombre de Paramètres
Considerons la fonction linear simple:

> ```f:x -> f(x)``` avec ```x ∈ N*```

Voici une répresentation de la fonction 

```php
    function f(int $x): mixed { ... }
```

Pour mieux comprendre les défis et les solutions liés aux fonctions ou méthodes avec un grand nombre de paramètres, examinons quelques exemples concrets issus de différentes situations de programmation.

Considerons maintenant une fonction à multiple variables : 

> ```f(X1,…,Xn)``` avec ```X ∈ J``` (```J``` ici represente une semble d'objets de nature heterogenes)


Voici une répresentation de la fonction

```php
    function f(
       int $x, 
       string $x1, 
       array $x2, 
       Object $x3,
       .
       .
       .
       TypeX $Xn
    ): mixed { ... }
```

Ici, plusieurs défis majeurs se posent, impactant la conception, la lisibilité, la maintenance et l'efficacité du code. Ces défis peuvent compromettre la qualité globale du logiciel et rendre sa gestion complexe au fil du temps.

- **a) Complexité et Lisibilité :**

Les fonctions avec un grand nombre de paramètres deviennent rapidement complexes à comprendre. Les appels de fonction longs et encombrés peuvent compliquer la lecture du code source, ce qui augmente la probabilité d'erreurs de programmation. Les développeurs peuvent avoir du mal à comprendre la logique et le but de chaque paramètre, ce qui nuit à la maintenabilité du code.

- **b) Risques de Confusion :**

Lorsque de nombreux paramètres sont impliqués, il existe un risque accru de mélanger l'ordre des paramètres lors de l'appel de la fonction. Cela peut conduire à des résultats incorrects, car les valeurs seront associées aux mauvais paramètres. Cette confusion est amplifiée lorsque les paramètres ont des types similaires ou que leurs noms ne sont pas suffisamment explicites.

- **c) Évolutivité et Flexibilité :**

Lorsque de nouvelles fonctionnalités sont ajoutées ou que les exigences évoluent, la modification de la signature d'une fonction avec de nombreux paramètres peut avoir des répercussions importantes sur d'autres parties du code qui l'appellent. La mise à jour de chaque appel de fonction peut devenir fastidieuse et potentiellement introduire des erreurs.

- **d) Maintenance et Cohésion :**

Les fonctions avec un grand nombre de paramètres ont tendance à avoir une responsabilité plus large, ce qui peut entraîner un manque de cohésion et une difficulté accrue à les maintenir. Les modifications ou les corrections de bogues dans une fonction complexe peuvent potentiellement affecter de nombreuses parties du code.

- **e) Tests et Débogage :**

Tester des fonctions avec de nombreux paramètres nécessite une couverture exhaustive des cas de test pour toutes les combinaisons possibles de valeurs. Le débogage devient également plus complexe, car il est difficile de déterminer quelle valeur de paramètre a contribué à un comportement indésirable.

Pour atténuer ces défis, il est crucial d'adopter des pratiques de conception appropriées. Regrouper des paramètres connexes au sein d'objets ou de structures de données peut améliorer la lisibilité. L'utilisation de configurations par défaut et la limitation du nombre de paramètres requis dans les appels de fonction peuvent également simplifier l'utilisation des fonctions. Enfin, la documentation et l'adoption de bonnes pratiques de gestion des fonctions avec de nombreux paramètres contribueront à garantir un code plus lisible, maintenable et évolutif.

## Proposition de solution

Reprenons la fonction à multiple variables

> ```f(X1,…,Xn)``` avec ```X ∈ J``` (```J``` ici represente une semble d'objets de nature heterogenes)

Si nous considerons que :
> ```(Xi)i∈I``` = ```X1,…,Xn```

On obtiens 

> ```f((Xi)i∈I)``` avec ```(Xi)i∈I``` l'ensemble des objets heterogenes.

Voici une répresentation de la fonction

```php
    function f(array $parametersList): mixed { ... }
```

En terme d'écriture notre code semble beaucoup plus simpples, mais nous perdons en terme de **Lisibilité** et [**typage**](https://www.php.net/manual/fr/language.types.declarations.php#language.types.declarations) Nous savons seulement que notre function attends un e tableau heterogene des objects, mais nous ne savons pas concretement les quels, ni comment les nommers
Par example si notre function attends un parametre du type age, nous ne sommes pas sûre que la valeur envoyé appartient à l'ensemble N*.

Nous pourrions essayer de resoudre ce probleme avec l'implementation suivante :

```php
    function f(array $parametersList): mixed {
        if (!isset($parametersList['age']) || !is_int($parametersList['age'])) {
            throw new InvalidArgumentException('Invalid argument, "age" param must be int '.gettype($parametersList['age']).' given');
        }
        ... 
    }
```

Cepandant, dans le cadre d'une fonction à multiple variable on reviendra vite sur la problematique initiale, à savoir, la lisibilité, maintenabilité.
Nous pouvons constater égelement que notre function fait désormais beaucoup trop de choses, or la puissance des fonctions réside dans leur capacité à découper un problème complexe en problèmes plus petits et gérables, en suivant le principe de la modularité. Cela permet aux développeurs de concentrer leur attention sur des parties spécifiques du programme à la fois, rendant le processus de développement plus efficace, plus clair et plus facile à maintenir.

La solution ideal serait donc d'externaliser toute la partie concernant la validation des parametres de notre function :

```php
    function f(array $parametersList): mixed {
        valide_mes_params($parametersList);
        ... 
    }
    
    function valide_mes_params(array $parametersList): void {
        if (!isset($parametersList['age']) || !is_int($parametersList['age'])) {
            throw new InvalidArgumentException('Invalid argument, "age" param must be int '.gettype($parametersList['age']).' given');
        }
    }
```

### Requirements
- PHP >= 8.1
- Symfony [OptionsResolver Component](https://symfony.com/doc/current/components/options_resolver.html)

> **NOTE:** Within a symfony project you can use ```Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface``` instead of ```PululuK\Example\Core\MyClassParameter```.


### Install
```bash
composer install
```

### Run tests
```bash
./vendor/bin/phpunit tests
```

### Try
```bash
php -f main.php
```

### How to use

```php
use PululuK\Example\Classes\MyClass;
use PululuK\Example\Core\MyClassWrapper;

$myClas = new MyClass();
$myClasWrapper = new MyClassWrapper($myClas);

$result1 = $myClasWrapper->get_customer(['idCustomer' => 1]);

$result2 = $myClasWrapper->get_customers([
    'enabledOnly' => true,
    'limit' => 10
]);

$result3 = $myClasWrapper->create_customer([
    'firstName' => 'PululuK',
    'lastName' => 'KA',
    'brithDayDate' => '23-10-1993',
    'email' => 'test@test.com',
    'enableNewsLetter' => true,
]);

print_r($result1);
print_r($result2);
print_r($result3);
```