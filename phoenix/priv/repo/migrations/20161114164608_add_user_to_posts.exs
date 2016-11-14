defmodule Blogmvc.Repo.Migrations.AddUserToPosts do
  use Ecto.Migration

  def change do
    alter table(:posts) do
      add :user_id, references(:users)
    end
  end
end
