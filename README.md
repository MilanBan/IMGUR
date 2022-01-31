# IMGUR (clone) 

## After clone project:

```
1. run `composer install`
2. create database 
3. fill `.env.example` file with database parameters
4. rename `.env.example` to `.env`
5. navigate to public folder and run `php -S localhost:8080`
6. enter in browser route `http://localhost:8080/imgur`
```

## to modify the database
```
1. run sql queries from `sqlquery.sql` file
2. to run seeder enter route `http://localhost:8080/seed`
```

## info
- Project use redis (requires to be installed redis on OS)
- Default password for users from database is `password`
