
# <center><big>Gérer ses campagnes Mailchimp sous Ecclesia**CRM** </big></center>

**IMPORTANT** pour la gestion des images, le gestionnaire de fichier doit pointer sur le dossier publique.

En effet, toutes les images insérées dans la campagne doivent avoir des liens publiques et non privés.

## Créer sa première campagne

On utilise le bouton suivant

![Screenshot](../../img/mailchimp/campaignCreation.png)

Avec la boite de dialogue

![Screenshot](../../img/mailchimp/campaignCreation1.png)

Vous pourrez saisir le titre de votre campagne et le sujet du mail

## Gestion d'un Mail type (code champ : publipostage)

Il est maintenant d'utiliser les codes champs de Mailchimp, un code champ permet de faire des mail type comme des lettres types (ce que l'on appelle communément le publipostage).

![Screenshot](../../img/mailchimp/campaignCreation3.png)

L'exemple ci-dessous, inclus FNAME (le prénom), LNAME (le nom) la date de création d'envoi du mail.

![Screenshot](../../img/mailchimp/campaignCreation4.png)

Quand la campagne sera envoyée, les prénoms, noms de chaque utilisateurs seront substitués à la place de chaque code champ.

- Il est possible de mettre en place le lien de désabonnement par rapport à la liste de diffusion<br>
Pour cela, on utilise le code champ<br>
 ![Screenshot](../../img/mailchimp/campaignCreationUnsubscribe1.png)<br>
On obtient<br>
![Screenshot](../../img/mailchimp/campaignCreationUnsubscribe2.png)<br>
On sélectionne le lien ````*|UNSUB|*```` et on utilise le bouton <br>
 ![Screenshot](../../img/mailchimp/campaignCreationUnsubscribe3.png)<br>
On obtient<br>
![Screenshot](../../img/mailchimp/campaignCreationUnsubscribe4.png)

Puis on valide par "Ok".

**Remarque** Dans les réglages généraux, il est possible de rajouter l'adresse et le numéro de téléphone de chaque utilisateur.

![Screenshot](../../img/mailchimp/mailchimpaddressphonesettings.png)

## Insérer des Images ou des Documents

Vous pourrez insérer des images ou des documents

- par glisser déposer dans la zone de texte
![Screenshot](../../img/mailchimp/campaignCreation2.png)<br>
Vous constaterez en double-cliquant sur l'image, que le lien est publique et pointe sur le dossier de l'utilisateur courant dans un conteneur sous forme UUID
![Screenshot](../../img/mailchimp/campaignImageInsertion.png)<br>
Vous pourrez ici, changer la taille de l'image.
- ou par le gestionnaire de fichier via le fait d'insérer des images.<br>
![Screenshot](../../img/mailchimp/insertcampaignimagebrowse1.png)<br>
Une boite de dialogue<br>
![Screenshot](../../img/mailchimp/insertcampaignimagebrowse2.png)<br>
On clique le bouton "Parcourir le serveur"<br>
![Screenshot](../../img/mailchimp/insertcampaignimagebrowse3.png)<br>
On obtient le gestionnaire de fichier<br>
![Screenshot](../../img/mailchimp/insertcampaignimagebrowse4.png)<br>
On peut télécharger une image sur le serveur<br>
![Screenshot](../../img/mailchimp/insertcampaignimagebrowse5.png)<br>
On sélectionne le fichier à insérer dans le document<br>
![Screenshot](../../img/mailchimp/insertcampaignimagebrowse6.png)<br>

- par glisser-déposer de fichier, très utile pour télécharger un document en pièce jointe dans le mail
![Screenshot](../../img/mailchimp/mailchimpDocInsert1.png)<br>
Voici la pièce jointe<br>
![Screenshot](../../img/mailchimp/mailchimpDocInsert2.png)<br>

Une fois la campagne finalisée, vous pourrez "Enregistrer" votre campagne.

## Planifier vos envois de Mails

Pour cela, il faut enregistrer votre campagne, vous serez basculer sur la page d'envoi

![Screenshot](../../img/mailchimp/campaignplanification1.png)<br>
![Screenshot](../../img/mailchimp/campaignplanification2.png)<br>
Ici pour pourrez, enregistrer, envoyer, supprimer ou fixer une date et une heure pour votre campagne.<br>
![Screenshot](../../img/mailchimp/campaignplanification3.png)<br>

Il sera possible aussi de la modifier pour une version ultérieure.

**Remarque** Il est recommandé, de créer des modèles de documents pour les utiliser une autre fois, pour cela consulter la partie "Modèle de documents", dans la partie "Manuel Utilisateur" et "Documents".

