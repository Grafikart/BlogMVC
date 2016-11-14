defmodule Blogmvc.Repo.Migrations.CreatePost do
  use Ecto.Migration

  def change do
    create table(:posts) do
      add :name, :string
      add :slug, :string
      add :content, :string, size: 4_294_967_295
      add :category_id, references(:categories)
      timestamps()
    end
    create index(:posts, [:category_id])
  end
end
