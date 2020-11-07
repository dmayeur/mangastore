<p align="center">
  <img width="300" height="300" src="/front/src/media/logo.png" alt="mangastore logo">
</p>

# mangastore

## Description

This is a fictive e-commerce site done as 3WA end of formation project.

## Getting Started

### Database

Use the SQL export of the database to create the DB (**mangastore-dump.sql**)

### In api folder

```
composer install
```

The server must accept htaccess redirections.
You may need to change the configuration of the DB access in **system/Database.php** (mine was made with default xampp config, root and no password account)

### In front folder

```
npm install
```

You may need to change **vue.config.js** proxy accordingly to your config (mine was made with default xampp config, aka redirecting the requests to the 80 port)

```
npm run serve
```

And you can finally access to the site !

## Technologies used

### Front

I made everything with Vue.js.

The connection with the back is made with API calls with Axios.

Some Form validators are made here and not in the back for instant feedback and better UX. The checks are more lenient on admin routes.

Vuex store is used to handle authentication and the cart through the app.

### Back

The back is a RESTful API.

I made a tiny framework doing stuff like routing, auth and basic REST functions.
The project respect MVC pattern.

The authentication is made using JWT tokens to keep it as RESTful as it gets.

## General Principles

I tried my best to respect SoC and DRY principles.

For exemple, all the API calls logic are made in external JS files so the view doesn't have to bother with how the API should be called. Moreover, I also used the broker pattern so if I ever want to change the API calls from Axios library to another it would be done easily without redoing all my app.

## Examples

A few screens to show how the site look like:

<p float="left">
  <img src="/exemple1.png" width="32%" height="auto" />
  <img src="/exemple2.png" width="32%" height="auto"/>
  <img src="/exemple3.png" width="32%" height="auto"/>
</p>

## Wrapping up

There's always the possibility of adding extra features for the site, but I think I found a good middle ground to show what I'm capable of.

It made me getting use to Vue, explore different things (like Vuex store), I have made lot of different things in the site (Auth with cookies, Cart with localstorage, a CRUD, a rating/review system...)

Making a mini framework from scratch (beside a JWT-token library) was definitely my favourite part of the project. I built it slowly, added features everytime I needed them. Thinking how to change it to make it better etc.

I'm pretty satisfied with how it turned out, I managed to code the features I wanted, and I was able to solve all the issues I encountered, which is the most important.
