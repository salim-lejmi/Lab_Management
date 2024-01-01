# pour récupérer ce projet sur votre machine:

Tapez les commandes suivantes:

1. $ git clone https://github.com/salim-lejmi/Lab_Management.git
2. $ cd Lab_Management
3. $ composer install
4. $ symfony console doctrine:database:create

Effacer le contenu du dossier migration du projet ensuite taper les commandes suivantes

5. $ symfony console make:migration
6. $ symfony console doctrine:migrations:migrate

creer les fixtures

7. $ php bin/console doctrine:fixtures:load

