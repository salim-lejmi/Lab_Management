# pour récupérer ce projet sur votre machine:

Tapez les commandes suivantes:

1. $ git clone https://github.com/salim-lejmi/LabManagement.git
2. $ cd LabManagement
3. $ composer install
4. $ symfony console doctrine:database:create

Effacer le contenu du dossier migration du projet ensuite taper les commandes suivantes

5. $ symfony console make:migration
6. $ symfony console doctrine:migrations:migrate
