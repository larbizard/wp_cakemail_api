# Informations:

Author: Savoir-Faire Linux

Contributor: Gharib Larbi

Function: cakemail_api_client

License: https://opensource.org/licenses/GPL-3.0

# How to use:

1- Contact Cakemail (or one of their distributors ex: Courilleur) and ask for you api_key that is related to you email and password

2- Once you get these informations use the following curl command to get your related user_key:
curl -H 'apikey: YOUR_API_KEY_PROVIDED_BY_CAKEMAIL' -d 'email=YOUR_EMAIL&password=YOUR_PASSWORD' https://api.wbsrvc.com/User/Login

3- Add this code in the functions.php file in your Wordpress Theme and use [compteur_signatures lang="fr"] or [compteur_signatures] shortcode anywhere in your Wordpress pages or posts

For more informations about cakemail API visit: https://developer.cakemail.com/
