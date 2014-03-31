# Asp.Net Mvc


## Get started

gives you full control over markup for enjoyable, agile development. 
ASP.NET MVC includes many features that enable fast, TDD-friendly development for creating sophisticated applications that use the latest web standards.

[Official site](http://www.asp.net/mvc)



## Notes

* I used a MySql database instead SQL server and it gives me some problems
* SqlDepedency is not working with MySQL, so I had to use a trick to invalid cache
* I cleared the project from unused files/methods


## Install

* Open the projetc file : BlogMvc.Web.sln

If there are some missing dll files :
* enable "nuget restore package" option on the solution 
* or reinstall all  packages  (nuget restore {path}\YourSolution.sln) see [http://docs.nuget.org/docs/reference/command-line-reference#Restore_command](http://docs.nuget.org/docs/reference/command-line-reference#Restore_command)


* Edit the connexion string in the  Web.Config file to setup your database (see BlogMvcContext)
