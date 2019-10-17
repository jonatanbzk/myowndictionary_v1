ssh -i ~/.ssh/aws.pem bitnami@35.181.46.138

1. liste langue create dico => language from DB
2. liste tag 'tag_name'
3. changer tag ['personel_language_array']
4. show word
5. add word erase word change word
6. test


Modified :

1. commit
- add list language en_US.php & fr_FR.php
- model.php
  1. create fonction languageId that return language with id
  2. modified getLanguages() to return an array with id and language
dictionaryPage.php
modified form add tag :
  change loop return id language

2. now change getTag
first verify step 1!! commit
change tags db just use id lang change old user
change function get tag use only id and change with function languageId
