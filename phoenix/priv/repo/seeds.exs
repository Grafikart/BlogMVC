# Script for populating the database. You can run it as:
#
#     mix run priv/repo/seeds.exs
#
# Inside the script, you can read and write to any of your
# repositories directly:
#
#     Blogmvc.Repo.insert!(%Blogmvc.SomeModel{})
#
# We recommend using the bang functions (`insert!`, `update!`
# and so on) as they will fail if something goes wrong.
alias Blogmvc.Repo
alias Blogmvc.User

Repo.insert!(%User{
  username: "admin",
  password: Comeonin.Bcrypt.hashpwsalt("admin")
})

Repo.insert!(%Category{name: "Demo", slug: "demo"})
Repo.insert!(%Category{name: "Demo 2", slug: "demo-2"})