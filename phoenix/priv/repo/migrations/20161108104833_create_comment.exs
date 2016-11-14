defmodule Blogmvc.Repo.Migrations.CreateComment do
  use Ecto.Migration

  def change do
    create table(:comments) do
      add :username, :string
      add :mail, :string
      add :content, :string, size: 4_294_967_295
      add :post_id, references(:posts)
      timestamps()
    end
    create index(:comments, [:post_id])
  end
end
