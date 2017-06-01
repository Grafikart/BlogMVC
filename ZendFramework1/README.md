ZendFramework 1.12
==================

**ZendFramework1** is an old but good framework. I had it to learn it in few weeks so I thought it will be a good idea to include in this repository.


How to install
--------------

Clone this repository and move into the **ZendFramework1.12** directory

```bash
$ git clone https://github.com/Grafikart/BlogMVC.git
```

**ZendFramework1.12** does not use Composer so you need to download and copy (or link) ZendFramework1.12 librairy folder.

```bash
$ wget https://packages.zendframework.com/releases/ZendFramework-1.12.20/ZendFramework-1.12.20.tar.gz
$ tar zxvf ZendFramework-1.12.20.tar.gz
$ cp -r ZendFramework-1.12.20/library/Zend blogmvc/ZendFramework1/library/
```

**ZendFramework1.12** does not include any migration system. So you have to build the default database from the *dump.sql* file

```bash
$ cd blogmvc/ZendFramework1
$ sqlite3 data/database.sqlite3 < data/dump.sql
```

Enjoy!