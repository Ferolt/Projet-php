
#Cree la table user

docker exec -it projet-php-web-1 php Migration/UserMigration.php up

#supprimer la table user

docker exec -it projet-php-web-1 php Migration/UserMigration.php down
