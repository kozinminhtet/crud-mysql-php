# Tutorial 08

## CRUD with post table

## Table

posts
- id (unsigned int, auto increment, primary key)
- title (varchar, length:255)
- content (text)
- is_published (boolean) 0, 1
- created_at (timestamp, default value: current timestamp)
- updated_at (timestamp, default value: current timestamp)

CURD
- C  (Create)
- U  (Update or Edit)
- R  (Read or View or List)
- D  (Delete (confirm))

## Folder Structure
```
.
css/
├── reset.css
└── style.css
demo/
└── Tuto_08.png
images/
├── example_01.png
├── example_02.png
└── ...
libs/
index.php
README.md
```

## Validation Rules
- Title field is required
- Content field is required

<hr>

## Post Create Design
![post_create.png](demo/post_create.png)

## Post Delete Confirm Alert Design
![post_delete_confirm_alert.png](demo/post_delete_confirm_alert.png)

## Post Detail Design

![post_detial.png](demo/post_detial.png)

## Post Edit Design

![post_edit.png](demo/post_edit.png)

## Posts List Design

![post_list.png](demo/post_list.png)
