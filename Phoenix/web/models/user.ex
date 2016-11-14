defmodule Blogmvc.User do
  use Blogmvc.Web, :model
  import Comeonin.Bcrypt, only: [checkpw: 2]

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

  @doc """
  Login a user
  """
  def login(%{"username" => username, "password" => password}) do
      user = Blogmvc.Repo.get_by(__MODULE__, username: username)
      if user == nil do
        {:error, :no_record}
      else
        if checkpw(password, user.password) do
          {:ok, user}
        else
          {:error, :password_missmatch}
        end
      end
  end

  def list do
    from(u in __MODULE__, select: {u.username, u.id})
  end

end
