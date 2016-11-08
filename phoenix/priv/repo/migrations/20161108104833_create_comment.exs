defmodule Blogmvc.Repo.Migrations.CreateComment do
  use Ecto.Migration

  def change do
    create table(:comments) do
      add :username, :string
      add :mail, :string
      add :content, :string
      add :post_id, references(:posts, on_delete: :nothing)

      timestamps()
    end
    create index(:comments, [:post_id])

  end
end
