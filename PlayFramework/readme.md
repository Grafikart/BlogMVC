# A MVC blog with Play Java 2.5

### How to setup

  - Make sure you have the [Oracle Java JDK 8](http://www.oracle.com/technetwork/java/javase/downloads/jdk8-downloads-2133151.html) installed
  - Download the [activator](https://playframework.com/download) (v2.5.8)
  - Put the activator file in the project file
  - Make sure your database is already configured (see database configuration point)

```sh
$ cd PlayFramework
$ ./activator clean
$ ./activator run
```

And open http://localhost:9000

### Database configuration

In my case, I used postgresql for this project. You can use an other database engine, just see the [how to](https://www.playframework.com/documentation/2.5.x/JavaDatabase) on play's documentation.

If you already have a postgresql server, you must create :

- A database named "blog"
- A user named "postgres" with "admin" as a password
- Or, you can change these parameters in application.conf file.

**Enjoy!**
