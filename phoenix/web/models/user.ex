defmodule Blogmvc.User do
  use Blogmvc.Web, :model

  schema "users" do
    field :username, :string
    field :password, :string
  end

  @doc """
  Builds a changeset based on the `struct` and `params`.
  """
  def changeset(struct, params \\ %{}) do
    struct
    |> cast(params, [:username, :password])
    |> validate_required([:username, :password])
  end
end
