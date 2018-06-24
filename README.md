For using that forum you will need: 
* ArangoDB installed and launched 
* database 'helium' 
* composer (it will help to build dependencies)
For more info about connection to database go to venus\Config\Services.php

Here is a list of collections in 'helium' database:

* forum_categories
* forum_groups 
* forum_messages 
* forum_reply 
* forum_subjects 
* login 
* topics 
* users 
* land_pages

Simple data for forum_categories: 
```
{
  "description": "Oyuncular tarafından hazırlanmış rehberler ve ipuçları sayesinde Ejder Yolu oynarken ihtiyaç duyacağınız bilgileri burada bulabilirsiniz.",
  "group": "tr_ejderyolu",
  "hidden": false,
  "language": "tr",
  "name": "Rehberler ve Strateji",
  "order": 200,
  "total_topics": 0
}
```
Simple data for forum_groups: 
```
{
  "lang": "tr",
  "name": "War2 - Red Alert",
  "order": 300
}
```
Simple data for forum_messages: 
```
{
  "by": "FDX70XM2L1",
  "hidden": true,
  "message": "<p class=\"cye-lm-tag\"><img style=\"width: 52px;\" src=\"https://f001.backblazeb2.com/file/salabox/-1201331.png\"><br></p>",
  "time": 1491066821
}

{
  "message": "<p>Ahaha, right, le's discuss that. What color of merging do you prefer? </p>",
  "time": 1523458292,
  "by": "FJO2QZYKZ6"
}
```
Simple data for forum_reply (it is a graph): 
```
_from:forum_subjects/13827729 \n
_to:forum_messages/13827733
```
Simple data for forum_subjects: 
```
{
  "category": "ejderyolu",
  "subject": "Aktualizacje 29 marca (łączenie serwerów) 2",
  "replies": 0,
  "views": 1,
  "time": 1523457661,
  "by": "FJO2QZYKZ6"
}
```
Simple data for login: 
```
{
  "email": "osman4@osman.com",
  "password": "osman4",
  "user": "FFDJMHXPAF",
  "vendor": "salacom"
}
```
Simple data for topics (it is a graph): 
```
_from:courses/31619135 \n
_to:tags/31619342
```
Simple data for users: 
```
{
  "added_partners": null,
  "avatar": "https://www.gravatar.com/avatar/470563722de2fff0a8c262bd434ae97c",
  "company_name": "REGGY",
  "email": "user2@venus.dev",
  "forumtitle": "☆",
  "info": "cool guy",
  "name": "Bob",
  "nick": "user2",
  "partner_site": "https://www.gry-online.pl",
  "payout": {
    "automatic": true,
    "email": "titov@dlit.dp.ua",
    "method": "payoneer"
  },
  "phone": "+825180000",
  "ref": 1,
  "roles": [
    "user",
    "partner"
  ],
  "surname": "Marley"
}
```