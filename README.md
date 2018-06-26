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
* users 
* land_pages

Simple data for forum_categories (value of 'group' is a '_key' of a group from collection 'groups'): 
```
{
  "description": "Description",
  "group": "5338074",
  "hidden": false,
  "language": "en",
  "name": "First category",
  "order": 200,
  "total_topics": 1
}
```
Simple data for forum_groups (this one has '_key' = 5338074 in my case): 
```
{
  "lang": "en",
  "name": "First Group",
  "order": 200
}
```
Simple data for forum_messages (in field 'by' please insert '_key' of user which you have in collection 'users'): 
```
{
  "message": "<p><span style=\"color: rgb(101, 101, 101);\">First reply in First topic in First category</span><br></p>",
  "time": 1530000488,
  "by": "FSO7V0RT1C"
}
{
  "message": "<p>First content in First topic in First category</p>",
  "time": 1529999397,
  "by": "FSO7V0RT1C"
}
```
Simple data for forum_reply (it is a graph): 
```
_from:forum_subjects/5338633 
_to:forum_messages/5338637
```
```
_from:forum_subjects/5338633 
_to:forum_messages/5339656
```
```
where 5338633 is a '_key' of subjet from 'forum_subjects'
and 5338637 and 5339656 are '_key' values of messages from 'forum_messages'
```
Simple data for forum_subjects (value of 'category' is a '_key' of category from collection 'categories', value of 'by' is a '_key' of user from 'users'): 
```
{
  "category": "5337984",
  "subject": "First topic in First category",
  "replies": 1,
  "views": 3,
  "time": 1529999397,
  "by": "FSO7V0RT1C"
}
```
Simple data for login (value of 'user' is a '_key' of user from collection 'users'): 
```
{
  "ref": "",
  "user": "FSO7V0RT1C",
  "vendor": "salacom",
  "email": "osman4@osman.com",
  "password": "osman4"
}
```
Simple data for users: 
```
{
  "nick": "osman4",
  "forumtitle": "☆",
  "avatar": "https://www.gravatar.com/avatar/5008bc4272b4a460db2a819746eba443",
  "roles": [
    "user"
  ]
}
```