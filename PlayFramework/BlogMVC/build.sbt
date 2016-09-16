name := "BlogMVC"

version := "1.0"

lazy val `blogmvc` = (project in file(".")).enablePlugins(PlayScala)

scalaVersion := "2.11.7"

libraryDependencies ++= Seq( jdbc , cache , ws   , specs2 % Test )

libraryDependencies += "org.postgresql" % "postgresql" % "9.4.1210.jre7"


unmanagedResourceDirectories in Test <+=  baseDirectory ( _ /"target/web/public/test" )  

resolvers += "scalaz-bintray" at "https://dl.bintray.com/scalaz/releases"

libraryDependencies ++= Seq(
  javaJpa,
  "org.hibernate" % "hibernate-entitymanager" % "5.1.0.Final"
)

PlayKeys.externalizeResources := false

//lazy val myProject = (project in file("."))
//  .enablePlugins(PlayJava, PlayEbean)

libraryDependencies += "org.jadira.usertype" % "usertype.core" % "6.0.1.GA"
