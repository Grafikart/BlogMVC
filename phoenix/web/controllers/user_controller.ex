defmodule Blogmvc.UserController do

  use Blogmvc.Web, :controller
  alias Blogmvc.User

  def login(conn, _params) do
    user = User.changeset(%User{})
    render conn, "login.html", user: user
  end

  def do_login(conn, %{"user" => user_params}) do
    case User.login(user_params) do
      {:ok, user} ->
        conn
          |> put_session(:auth, user)
          |> redirect(to: admin_post_path(conn, :index))
      {:error, _error} ->
        conn
          |> put_flash(:error, "Wrong username or password")
          |> redirect(to: user_path(conn, :login))
    end
  end

end