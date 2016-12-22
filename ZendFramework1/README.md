ZendFramework 1.12
==================

**ZendFramework1** is an old but good framework. I had it to learn it in few weeks so I thought it will be a good idea to include in this repository.


How to install
--------------

Clone this repository and move into the *ZendFramework1* directory

```bash
$ git clone https://github.com/Grafikart/BlogMVC.git
$ cd blogmvc/ZendFramework1
```

**ZendFramework1** does not include any migration system. So you have to build the default database from the *dump.sql* file

```bash
$ sqlite3 data/database.sqlite3 < data/dump.sql
```

Then it's all, ZendFramework's sources are already included in *library* folder!