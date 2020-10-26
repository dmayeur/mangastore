<p align="center">
  <img width="300" height="300" src="/front/src/media/logo.png" alt="mangastore logo"> 
</p>
# mangastore

## Description

This is a fictive e-commerce site done as 3WA end of formation project.

## Getting Started

### Database

Use the SQL export of the database to create the DB

### In api folder

```
composer install
```

The server must accept htaccess redirections.
You may need to change the configuration of the DB access in **system/Database.php**

### In front folder

```
npm install
```

You may need to change **vue.config.js** proxy accordingly to your config (mine was made with default xampp config)

```
npm run serve
```

And you can finally access to the site

## Technologies used

### Front

I made everything with Vue.js.

Form validators are made here and not in the back for better feedback and UX.

The connection with the back is made with API calls with Axios.

### Back

The back is a RESTful API.

I made a tiny framework doing stuff like routing, auth and basic REST functions.
The project respect MVC pattern.

The authentication is made using JWT tokens to keep it as RESTful as it gets.

## Examples

A few screen to show how the site look like:
