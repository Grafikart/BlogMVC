#mkFramework http://mkframework.com

### Logs:
*at moment (2013/10/06) finished
*at moment (2013/10/05) it needs url rewriting
*at moment (2013/10/05) it needs cache management + url rewriting

### Installation
1. Run composer install
2. Create a new database ( BlogMVC)
3. Open conf/connexion.ini.php and change username/password if needed
4. In mysql, execute the dump https://raw.githubusercontent.com/Grafikart/BlogMVC/master/dump.sql
Enjoy ;)


note: directories data/log and data/cache should be writable by apache, please change rights if you have some problems
