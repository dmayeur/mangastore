# MangaStore

## Description

This is a fictive e-commerce site done as 3WA end of formation project.

## Getting Started

### Database

Use the SQL export of the database

### In api folder

```
composer install
```


### In front folder

```
npm install
```

Then change vue.config.js proxy accordingly to your config (mine made with default xampp config)


## Technologies used

### Front

I used VUE.JS for the site and CRUD.

The connection with the back is made with API calls with Axios.

### Back

The back is a RESTful API.

I made a tiny framework doing stuff like routing, auth and basic REST functions.

The authentication is made using JWT tokens to keep it as RESTful as it gets.
