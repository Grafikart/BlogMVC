defmodule Blogmvc.Post do

  use Blogmvc.Web, :model

  schema "posts" do
    field :name, :string
    field :slug, :string
    field :content, :string
    timestamps()

    belongs_to :user, Blogmvc.User
    belongs_to :category, Blogmvc.Category
    has_many :comments, Blogmvc.Comment
  end

  @required_fields [:name, :content, :category_id, :user_id]
  @optional_fields [:slug]

  def changeset(struct, params \\ %{}) do
    changeset = struct
    |> cast(params, @required_fields, @optional_fields)
    |> slugify()
    |> validate_required(@required_fields)
    |> update_count(:category, :post_count)
  end

  def delete_changeset(struct) do
    struct |> cast(%{}, @required_fields) |> update_count(:category, :post_count, -1)
  end

  def slugify(changeset) do
    slug = get_change(changeset, :slug)
    name = get_change(changeset, :name) || Map.get(changeset.data, :name)
    if slug == nil do
      put_change(changeset, :slug, Slugger.slugify_downcase(name))
    else
      changeset
    end
  end

  def last2 do
    __MODULE__
      |> limit(2)
  end

end