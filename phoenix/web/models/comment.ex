defmodule Blogmvc.Comment do
  use Blogmvc.Web, :model

  schema "comments" do
    field :username, :string
    field :mail, :string
    field :content, :string

    belongs_to :post, Blogmvc.Post

    timestamps(@timestamps_opts ++ [inserted_at: :created, updated_at: false])
  end

  @doc """
  Builds a changeset based on the `struct` and `params`.
  """
  def changeset(struct, params \\ %{}) do
    struct
    |> cast(params, [:username, :mail, :content])
    |> validate_required([:username, :mail, :content])
  end

end
