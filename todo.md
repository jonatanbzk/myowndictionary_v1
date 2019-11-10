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
change tags db just use id lang change old user
change function get tag use only id and change with function languageId
Before :
CREATE TABLE `tags` (
  `id_tag` int(11) NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `tag_name2` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `language_1` varchar(255) NOT NULL,
  `language_2` varchar(255) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
After :
CREATE TABLE `tags` (
  `id_tag` int(11) NOT NULL,
  `tag_name` int(11) NOT NULL,
  `tag_name2` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `language_1` int(11) NOT NULL,
  `language_2` int(11) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
