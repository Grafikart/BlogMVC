defmodule Blogmvc.Plugs.Auth do
  import Plug.Conn
  import Phoenix.Controller, only: [redirect: 2, put_flash: 3]

  alias Blogmvc.Repo
  alias Blogmvc.User

  def init(_default) do
  end

  def call(conn, _default) do
    auth = get_session(conn, :auth)
    if auth do
      user = Blogmvc.Repo.get(User, auth.id)
      if user do
        conn
      else
        conn |> put_flash(:error, "Access forbidden") |> block
      end
    else
      block(conn)
    end
  end

  defp block(conn) do
    conn
      |> redirect(to: Blogmvc.Router.Helpers.user_path(conn, :login))
      |> halt
  end

end
