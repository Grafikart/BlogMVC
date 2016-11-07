defmodule Blogmvc.Post do

  use Blogmvc.Web, :model

  schema "posts" do
    field :name, :string
    field :slug, :string
    field :content, :string
    timestamps(@timestamps_opts ++ [inserted_at: :created, updated_at: false])
    belongs_to :user, Blogmvc.User
    belongs_to :category, Blogmvc.Category
  end

  def changeset(struct, params \\ %{}) do
    struct
    |> cast(params, [:name, :slug, :content])
    |> validate_required([:name, :slug, :content])
  end

end